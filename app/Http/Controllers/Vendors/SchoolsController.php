<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Staff\SchoolClassesController;
use App\Http\Requests\CreateSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\Expenditure;
use App\Models\Fee;
use App\Models\GeneralSetting;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools =
            School::where('vendor_id', user()->vendor->id)->get();
        return view('vendors.schools', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SchoolCategory::all();
        return view('vendors.create_edit_school', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSchoolRequest $request)
    {
        try {
            DB::beginTransaction();
            //created school admin
            $admin = new User();
            $admin->first_name = $request->admin_first_name;
            $admin->last_name = $request->admin_last_name;
            $admin->other_name = $request->admin_other_name;
            $admin->email = $request->admin_email;
            $admin->phone_number = $request->admin_phone_number;
            $admin->address = $request->admin_address;
            $admin->password = bcrypt('password');
            $admin->role_id = 3;
            $admin->save();

            //create school
            $school = new School();
            $school->name = $request->name;
            $school->code = $request->code;
            $school->email = $request->email;
            $school->address = $request->address;
            $school->country = $request->country;
            $school->state = $request->state;
            $school->phone_number = $request->admin_phone_number;
            $school->city = $request->city;
            $school->user_id = $admin->id;
            $school->school_category_id = $request->category;
            $school->vendor_id = $request->vendor;
            $school->save();
            (new SchoolClassesController)->createAlumniAndTrashClasses($school);
            DB::commit();
            return redirect()->back()->with('message', 'School created successfully');
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'School creation fail');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school = School::where('id', $id)->where('vendor_id', user()->vendor->id)->first();
        if (!$school) abort(404);

        $staffCount = School::find($id)->staff()->count();
        $studentCount = Student::where('school_id', $id)->whereHas('school_class', function ($q) {
            return $q->whereNotIn('name', ['Alumni', 'Trash']);
        })->active()->count();
        $subjectCount =
            Subject::where('school_id', $id)->count();
        $sectionCount = Section::where('school_id', $id)->count();
        $classCount = SchoolClass::where('school_id', $id)->whereNotIn('name', ['Alumni', 'Trash'])->count();
        $totalExpenditure = Expenditure::where('school_id', $id)->count();
        $totalFee = Fee::where(
            'school_id',
            $id
        )->count();
        $debitTransaction = Transaction::where('school_id', $id)->where('type', 'debit')->sum('amount', 0);
        $creditTransaction = Transaction::where('school_id', $id)->where('type', 'credit')->sum('amount', 0);

        return view('vendors.schools.home', compact(
            'staffCount',
            'studentCount',
            'subjectCount',
            'classCount',
            'sectionCount',
            'totalExpenditure',
            'totalFee',
            'creditTransaction',
            'debitTransaction'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = SchoolCategory::all();
        $school = School::findOrFail($id);
        return view('vendors.create_edit_school', compact('categories',  'school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //created school admin
            $admin =  User::findOrFail($request->user_id);
            $admin->first_name = $request->admin_first_name;
            $admin->last_name = $request->admin_last_name;
            $admin->other_name = $request->admin_other_name;
            $admin->email = $request->admin_email;
            $admin->phone_number = $request->admin_phone_number;
            $admin->address = $request->admin_address;
            $admin->save();

            //create school
            $school =  School::findOrFail($id);
            $school->name = $request->name;
            $school->code = $request->code;
            $school->email = $request->email;
            $school->address = $request->address;
            $school->country = $request->country;
            $school->state = $request->state;
            $school->phone_number = $request->admin_phone_number;
            $school->city = $request->city;
            $school->active = $request->active;
            $school->vendor_id = $request->vendor;
            $school->school_category_id = $request->category;
            $school->save();

            DB::commit();
            return redirect()->back()->with('message', 'School updated successfully');
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'School update fail');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function resetPassword(Request $request, School $school)
    {
        $data = $this->validate($request, [
            'password' => 'required|string',
            // 'password_confirmation' => 'required|confirmed'
        ]);
        $school->user->update(['password' => bcrypt($request->password)]);
        return redirect()->back()->with('message', 'Password was change');
    }

    public function transfer(Request $request)
    {
        $user = user();
        // $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $schools =
            School::where('vendor_id', user()->vendor->id)->get();

        if ($request->query->count()) {
            $school =
                School::where('vendor_id', user()->vendor->id)->where('id', request()->school)->first();
            $class =  SchoolClass::where('id', request()->class)->where('school_id', request()->school)->first();
            $section =  Section::where('id', request()->section)->where('school_id', request()->school)->first();

            $students = Student::when($section, function ($query, $section) {
                return $query->where('section_id', $section->id);
            })->when($class, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })->where('school_id', request()->school)->active()->get();

            $sections = $class ? $class->sections : [];
            $class_id = $class ? $class->id : null;
            $section_id = $section ? $section->id : null;
            $school_id = $school ? $school->id : null;

            $classes = SchoolClass::where('school_id', request()->school)->get();
            return view('vendors.schools.students_transfer', compact('schools', 'classes', 'sections', 'students', 'class_id', 'section_id', 'school_id'));
        }
        return view('vendors.schools.students_transfer', compact('schools'));
    }

    public function processTransfer(Request $request)
    {

        $systemClasses = SchoolClass::where('school_id', $request->next_school)->whereIn('name', ['Alumni', 'Trash'])->pluck('id')->toArray();
        $request->validate([
            'next_school' => 'required|exists:schools,id',
            'next_class' => 'required|exists:school_classes,id',
            'next_section' => [
                Rule::requiredIf(function () use ($request, $systemClasses) {
                    return in_array($request->next_class, $systemClasses);
                }),
                // 'exists:sections,id'
            ],
            'students' => 'required'
        ], [
            'students.required' => 'Please Select atleast one student to promote'
        ]);
        try {
            DB::beginTransaction();
            $generalSettings = GeneralSetting::where('school_id', $request->next_school)->first();
            $nextClass = SchoolClass::where('id', $request->next_class)->first();
            $nextSchool = SchoolClass::where('id', $request->next_school)->first();
            $nextSection = SchoolClass::where('id', $request->next_section)->first();
            Student::find($request->students)->each(function ($student) use ($nextSchool, $nextClass, $nextSection, $generalSettings) {
                $student->school_class_id = $nextClass->id;
                $student->school_id = $nextSchool->id;
                $student->section_id = $nextSection ? $nextSection->id : $student->section_id;
                if ($nextClass->name == 'Alumni') {
                    $student->academic_session_id = $generalSettings->current_session_id;
                } else {
                    $student->academic_session_id = null;
                }
                $student->save();
            });
            DB::commit();
            return redirect()->back()->with('message', 'Selected Students have been transfered successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Promotion failed:' . $e->getMessage());
        }
    }
}
