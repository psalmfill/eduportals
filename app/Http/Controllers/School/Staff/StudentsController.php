<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentFormRequest;
use App\Models\AcademicSession;
use App\Models\Attendance;
use App\Models\GeneralSetting;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Illuminate\Support\Str;
use Image;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        if (request()->query->count() > 1) {
            $class =  SchoolClass::where('name', request()->class)->where('school_id', getSchool()->id)->first();
            $section =  Section::where('name', request()->section)->where('school_id', getSchool()->id)->first();
            $students = Student::when($section, function ($query, $section) {
                return $query->where('section_id', $section->id);
            })->when($class, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })->where('school_id', getSchool()->id)->orderBy('first_name', 'desc')->active()->paginate();
            $sections = $class ? $class->sections : [];
            $class_id = $class ? $class->id : null;
            $section_id = $section ? $section->id : null;
            return view('staff.students', compact('classes', 'sections', 'students', 'class_id', 'section_id'));
        }
        $students = Student::where('school_id', getSchool()->id)->orderBy('created_at', 'desc')->paginate(100);
        return view('staff.students', compact('classes', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        return view('staff.student.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentFormRequest $request)
    {
        try {
            DB::beginTransaction();


            //create Parent
            $parent = User::where('email', $request->parent['email'])
                ->orWhere('username', $request->parent['username'])
                ->orWhere('phone_number', $request->parent['phone_number'])->first();
            if (!$parent) {

                $parent = new User($request->parent);
                $parent->password = bcrypt('12345678');
                $parent->role_id = 4;
                $parent->save();
            }

            //create new student
            $student = new Student();
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->other_name = $request->other_name ?? '';
            $student->date_of_birth = Carbon::createFromDate($request->date_of_birth);
            $student->email = $request->email;
            $student->gender = $request->gender;
            $student->religion = $request->religion;
            $student->country = $request->country;
            $student->state = $request->state;
            $student->city = $request->city;
            $student->address_1 = $request->address_1;
            $student->address_2 = $request->address_2;
            $student->blood_group = $request->blood_group;
            $student->reg_no = $this->generateRegNumber();
            $student->genotype = $request->genotype;
            $student->school_class_id = $request->class;
            $student->section_id = $request->section;
            $student->school_id = getSchool()->id;
            $student->active = 1;

            $student->parent_id = $parent->id;
            //Perform passport upload
            $destination = null;
            //if passport
            if ($request->has('passport')) {
                $image = $request->file('passport');
                $imageName = time() . Str::random() . '.' . $image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode();
                $path = Storage::disk('public')->put('avatars/' . $imageName, $img);
                $destination = 'public/avatars/' . $imageName;
                $student->image = $destination;
            }
            $student->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            if (isset($destination)) {
                if (Storage::exists($destination)) {
                    Storage::delete($destination);
                }
            }

            return redirect()->route('students.index')->with(
                'error',
                'Failed to created Student'
            );
        }

        return redirect()->route('students.index')->with(
            'message',
            'New Student Created Successfully'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        return view('staff.student.view', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $sections = SchoolClass::find($student->school_class_id)->sections;
        return view('staff.student.edit', compact('student', 'classes', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $student = Student::findOrFail($id);
            //create Parent
            $parent_data = $request->parent;
            unset($parent_data['email']);
            $parent = User::find($student->parent_id);
            $parent->update($parent_data);

            //update student
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->other_name = $request->other_name ?? '';
            $student->date_of_birth = Carbon::createFromDate($request->date_of_birth);
            $student->gender = $request->gender;
            $student->religion = $request->religion;
            $student->country = $request->country;
            $student->state = $request->state;
            $student->city = $request->city;
            $student->address_1 = $request->address_1;
            $student->address_2 = $request->address_2;
            $student->blood_group = $request->blood_group;
            $student->genotype = $request->genotype;
            $student->school_class_id = $request->class;
            $student->section_id = $request->section;
            $student->active = $request->active ? 1 : 0;
            $oldImage = $student->image;
            $destination = null;
            //if passport
            if ($request->has('passport')) {
                $image = $request->file('passport');
                $imageName = time() . Str::random() . '.' . $image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode();
                $path = Storage::disk('public')->put('avatars/' . $imageName, $img);
                $destination = 'public/avatars/' . $imageName;
                $student->image = $destination;
            }
            $student->save();
            if (Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            if (isset($destination)) {
                if (Storage::exists($destination)) {
                    Storage::delete($destination);
                }
            }
            return redirect()->back()->with(
                'error',
                'Failed to update Student'
            );
        }

        return redirect()->back()->with(
            'message',
            'Student update Successfully'
        );
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

    public function promotion(Request $request)
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();

        if ($request->query->count()) {
            $class =  SchoolClass::where('id', request()->class)->where('school_id', getSchool()->id)->first();
            $section =  Section::where('id', request()->section)->where('school_id', getSchool()->id)->first();
            $students = Student::when($section, function ($query, $section) {
                return $query->where('section_id', $section->id);
            })->when($class, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })->where('school_id', getSchool()->id)->active()->get();
            $sections = $class ? $class->sections : [];
            $class_id = $class ? $class->id : null;
            $section_id = $section ? $section->id : null;

            $classes = SchoolClass::where('school_id', getSchool()->id)->get();
            return view('staff.students_promotion', compact('classes', 'sections', 'students', 'class_id', 'section_id'));
        }
        return view('staff.students_promotion', compact('classes'));
    }

    public function promote(Request $request)
    {
        $systemClasses = SchoolClass::where('school_id', getSchool()->id)->whereIn('name', ['Alumni', 'Trash'])->pluck('id')->toArray();
        $request->validate([
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
            $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();
            $nextClass = SchoolClass::where('id', $request->next_class)->first();
            $nextSection = SchoolClass::where('id', $request->next_section)->first();
            Student::find($request->students)->each(function ($student) use ($nextClass, $nextSection, $generalSettings) {
                $student->school_class_id = $nextClass->id;
                $student->section_id = $nextSection ? $nextSection->id : $student->section_id;
                if ($nextClass->name == 'Alumni') {
                    $student->academic_session_id = $generalSettings->current_session_id;
                } else {
                    $student->academic_session_id = null;
                }
                $student->save();
            });
            DB::commit();
            return redirect()->back()->with('message', 'Selected Students have been promoted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Promotion failed:' . $e->getMessage());
        }
    }

    public function attendance(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $studentsPresent = collect($request->students);
            $session_id
                = getSettings()->current_session_id;;
            $class_id = $request->class;
            $section_id = $request->section;
            $date = $request->date;
            $term_id = getSettings()->current_term_id;
            $students = Student::where('school_class_id', $class_id)
                ->where('section_id', $section_id)->active()->get();

            foreach ($students as $student) {
                Attendance::updateOrCreate([
                    'student_id' => $student->id,
                    'academic_session_id' => $session_id,
                    'term_id' => $term_id,
                    'school_id' => getSchool()->id,
                    'school_class_id' => $class_id,
                    'section_id' => $section_id,
                    'date' => date(
                        'Y-m-d',
                        strtotime($date)
                    ),
                ])->update([
                    'present' => $studentsPresent->contains($student->id),
                    'holiday' => $request->holiday ? 1 : 0
                ]);
            }

            return redirect()->back()->with('message', 'Attendance submited');
        }

        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();

        if (count($request->query())) {

            $date = $request->date;
            $currentClass = SchoolClass::findOrFail($request->class);
            $currentSession = AcademicSession::findOrFail(getSettings()->current_session_id);
            $currentSection = Section::findOrFail($request->section);
            $currentTerm = Term::findOrFail(getSettings()->current_term_id);
            $terms = Term::where('school_id', getSchool()->id)->get();
            $sessions = AcademicSession::all();
            $sections = $currentClass->sections;
            $students = Student::where('school_class_id', $currentClass->id)
                ->where('section_id', $currentSection->id)->active()->get();
            $attendances = Attendance::where([
                ['academic_session_id', $currentSession->id],
                [
                    'term_id',
                    $currentTerm->id
                ],
                ['school_id', getSchool()->id],
                ['school_class_id', $currentClass->id],
                ['section_id', $currentSection->id],
            ])->where(
                'date',
                date('Y-m-d', strtotime($date))
            )
                ->get();
            return view('staff.student.attendance', compact(
                'currentClass',
                'currentSession',
                'currentSection',
                'sessions',
                'classes',
                'sections',
                'students',
                'date',
                'terms',
                'currentTerm',
                "attendances"
            ));
        }

        $sessions = AcademicSession::all();
        $terms = Term::where('school_id', getSchool()->id)->get();
        return view('staff.student.attendance', compact('sessions', 'classes', 'terms'));
    }

    public function viewAttendance(Request $request)
    {
        $user = user();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        if ($request->query->count()) {

            // $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            $currentClass = SchoolClass::findOrFail($request->class);
            $currentSession = AcademicSession::findOrFail($request->session);
            $currentSection = Section::findOrFail($request->section);
            $currentTerm = Term::findOrFail($request->term);
            $terms = Term::where('school_id', getSchool()->id)->get();
            $month = $request->month;
            $sessions = AcademicSession::all();
            $sections = $currentClass->sections;
            $students = Student::where('school_class_id', $currentClass->id)
                ->where('section_id', $currentSection->id)->active()->get();

            // check if result exist
            $Attendances = Attendance::where([
                ['school_id', '=', getSchool()->id],
                ['academic_session_id', '=', $currentSession->id],
                ['term_id', '=', $currentTerm->id]
            ])->whereMonth('date', date_parse($month)['month'])->count();

            // if (!$Attendances)
            //     return redirect()->route('students.attendance.view')->with('error', 'No attendance found for query');



            return view('staff.student.view_attendance', compact(
                'currentClass',
                'currentSession',
                'currentSection',
                'sessions',
                'classes',
                'sections',
                'students',
                'month',
                'months',
                'terms',
                'currentTerm'
            ));
        }
        $sessions = AcademicSession::all();
        $terms = Term::where('school_id', getSchool()->id)->get();
        return view('staff.student.view_attendance', compact('sessions', 'classes', 'terms', 'months'));
    }

    public function selectStudents(Request $request)
    {

        $class_id = $request->class;
        $section_id = $request->section_id;
        $student = Student::where('section_id', $request->section)
            ->where('school_class', $request->class)->active()->get();
        $classes = SchoolClass::where('school_id', getSchool()->id)->get();
        $sections = SchoolClass::findOrFail($class_id)->sections;
        return view('staff.students', compact('classes', 'sections', 'students', 'class_id', 'section_id'));
    }

    private function generateRegNumber($n = 1)
    {
        $year = date('Y', strtotime(Carbon::now()));
        $count = $n + (Student::where('reg_no', 'like', '%DSS/' . $year . '/%')->count());
        $strcount = 4 - strlen($count);
        $str = '';
        while ($strcount) {
            $str .= '0';
            $strcount--;
        }
        $str .= $count;
        $reg = 'EDP/' . $year . '/' . $str;
        if (Student::where('reg_no', $reg)->first())
            return $this->generateRegNumber($n + 1);
        return $reg;
    }

    public function deleteStudent(Request $request)
    {
        $student = Student::findOrFail($request->student_id);

        if ($student->psychomotor_results()->count() || $student->comment_results()->count() || $student->attendances()->count()) {
            return redirect()->back()->with('error', 'Cannot delete student, student has records on the system. Contact the Admin for assistance if delete is still mandatory');
        }

        if ($student->delete()) {
            if ($student->image)
                Storage::delete($student->image);
        } else {
            return redirect()->back()->with('error', 'Failed to delete student');
        }
        return redirect()->back()->with('message', 'student deleted successfully');
    }

    public function alumni()
    {
        $class =  SchoolClass::where('name', 'Alumni')->where('school_id', getSchool()->id)->first();
        $sessions =  AcademicSession::all();
        $session = AcademicSession::find(request()->session);
        $students = Student::when($class, function ($query, $class) {
            return $query->where('school_class_id', $class->id);
        })->when($session, function ($query, $session) {
            return $query->where('academic_session_id', $session->id);
        })->where('school_id', getSchool()->id)->active()->get();

        return view('staff.alumni_students', compact('sessions', 'students'));
    }

    public function trash()
    {
        $class =  SchoolClass::where('name', 'Trash')->where('school_id', getSchool()->id)->first();
        $students = Student::when($class, function ($query, $class) {
            return $query->where('school_class_id', $class->id);
        })->where('school_id', getSchool()->id)->active()->get();

        return view('staff.trash_students', compact('students'));
    }

    public function emptyTrash()
    {
        $class =  SchoolClass::where('name', 'Trash')->where('school_id', getSchool()->id)->first();
        $students = Student::when($class, function ($query, $class) {
            return $query->where('school_class_id', $class->id);
        })->where('school_id', getSchool()->id)->active()->get();

        try {
            DB::beginTransaction();
            // loop each student and delete all results related to the student

            foreach ($students as $student) {
                // clear psychomotor
                $student->psychomotor_results()->delete();

                // clear all comment_results
                $student->comment_results()->delete();

                // clear all attendance record
                $student->attendances()->delete();

                // clear all mark store

                $student->mark_stores()->delete();

                // clear all comments remarks
                $student->comment_result_remarks()->delete();

                // set all student pins as null
                $student->pins()->update(['student_id' => null]);

                $student->delete();
                if ($student->image) {
                    Storage::delete($student->image);
                }
            }
            DB::commit();
            return redirect()->back()->with('message', 'Student Trash cleared Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Student Trash Clear Failed: ' . $e->getMessage());
        }
    }
    
    public function resetPassword(Request $request, $id)
    {

        $user  =  Student::findOrFail($id);;
        $user->password = bcrypt('12345678');
        if ($user->save()) {
            return redirect()->back()->with('message', ' Password has been reset to 123456789 ');
        }
        return redirect()->back()->with('error', 'Fail to reset password');
    }
}
