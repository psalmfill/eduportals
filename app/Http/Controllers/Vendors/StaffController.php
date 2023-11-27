<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\SchoolClassStaff;
use App\Models\Section;
use App\Models\Staff;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = Staff::whereHas('schools', function ($q) {
            return $q->where('vendor_id', user()->vendor->id);
        })->paginate(25);

        return view('vendors.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::all();
        // $designation = null;
        return view('vendors.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateStaffRequest $request)
    {
        try {
            DB::beginTransaction();
            $staff = Staff::where('email', $request->email)->first();
            if (!$staff) {
                $staff = new Staff();
                $staff->first_name = $request->first_name;
                $staff->last_name = $request->last_name;
                $staff->other_name = $request->other_name;
                $staff->username = $request->username;
                $staff->gender = $request->gender ?? 'male';
                $staff->address_1 = $request->address_1;
                $staff->address_2 = $request->address_2;
                $staff->phone_number = $request->phone_number;
                $staff->country = $request->country;
                $staff->religion = $request->religion;
                $staff->state = $request->state;
                $staff->city = $request->city;
                $staff->email = $request->email;
                $staff->date_of_birth = Carbon::createFromDate(date('d-m-Y', strtotime($request->date_of_birth)))->toDateString();
                $staff->password = bcrypt($request->password);

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
                    $staff->image = $destination;
                }
                $staff->save();
                $uni = $request->university;
                $uni['type'] = 'university';

                $sec = $request->secondary;
                $sec['type'] = 'secondary';

                $pri = $request->primary;
                $pri['type'] = 'primary';

                $staff->qualifications()->create($uni);
                $staff->qualifications()->create($sec);
                $staff->qualifications()->create($pri);
            }
            $staff->schools()->attach(getSchool()->id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            if (isset($destination)) {
                if (Storage::exists($destination)) {
                    Storage::delete($destination);
                }
            }
            return redirect()->back()->with('error', 'Could not create new Staff ');
        }

        return redirect()->route('vendors.staff.index')->with('message', 'New Staff Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return view('vendors.staff.view', compact('staff'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageSchools($id)
    {
        $staff = Staff::findOrFail($id);
        $schools =
            School::where('vendor_id', user()->vendor->id)->get();
        return view('vendors.staff.manage_schools', compact('staff', 'schools'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateSchools(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->schools()->sync($request->schools);
        return redirect()->back()->with('message', ' Staff Updated');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = Staff::find($id);
        return view('vendors.staff.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $staff = Staff::findOrFail($id);
            $staff->first_name = $request->first_name;
            $staff->last_name = $request->last_name;
            $staff->other_name = $request->other_name;
            $staff->username = $request->username;
            $staff->gender = $request->gender ?? 'male';
            $staff->address_1 = $request->address_1;
            $staff->address_2 = $request->address_2;
            $staff->phone_number = $request->phone_number;
            $staff->country = $request->country;
            $staff->religion = $request->religion;
            $staff->state = $request->state;
            $staff->city = $request->city;
            $staff->email = $request->email;
            $staff->date_of_birth =  Carbon::createFromDate(date('d-m-Y', strtotime($request->date_of_birth)))->toDateString();

            $oldImage = null;
            $destination = null;
            //if passport
            if ($request->has('passport')) {
                $oldImage = $staff->image;
                $image = $request->file('passport');
                $imageName = time() . Str::random() . '.' . $image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode();
                $path = Storage::disk('public')->put('avatars/' . $imageName, $img);
                $destination = 'public/avatars/' . $imageName;
                $staff->image = $destination;
            }
            $staff->save();
            $primary = $staff->qualifications()->where('type', 'primary')->first();
            $secondary = $staff->qualifications()->where('type', 'secondary')->first();
            $university = $staff->qualifications()->where('type', 'university')->first();
            $uni = $request->university;
            $university->update($uni);

            $sec = $request->secondary;
            $secondary->update($sec);

            $pri = $request->primary;
            $primary->update($pri);

            if ($oldImage and Storage::exists($oldImage)) {
                Storage::delete($oldImage);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            if (isset($destination)) {
                if (Storage::exists($destination)) {
                    Storage::delete($destination);
                }
            }
            return redirect()->back()->with('error', 'Could not Update Staff ');
        }

        return redirect()->back()->with('message', ' Staff Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        if ($staff->schools()->detach(getSchool()->id)) {
            return redirect()->route('vendor.staff.index')->with('message', 'Staff Deleted');
        }
        return redirect()->route('vendor.staff.index')->with('error', 'Deletion failed');
    }

    public function assignClasses()
    {
        $schoolClasses = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $staff = Staff::join('school_staff', 'staff.id', '=', 'school_staff.staff_id')->where('school_staff.school_id', request()->route()->school_id)->get();
        $staffWithClasses = $staff->filter(function ($s) {
            return $s->school_classes()->wherePivot('school_id', getSchool()->id)->get()->count();
        }); //Staff::join('school_staff', 'staff.id', '=', 'school_staff.staff_id')->where('school_staff.school_id',request()->route()->school_id)->get();
        $sections = Section::where('school_id', getSchool()->id)->get();
        return view('vendors.staff.classes', compact('schoolClasses', 'staff', 'staffWithClasses', 'sections'));
    }

    public function assignClassesStore(Request $request)
    {
        $staff = Staff::find($request->staff);
        $staff->school_classes()->wherePivot('school_id', getSchool()->id)->detach();
        $sections = $request->sections ?? [];

        foreach ($sections as $key => $value) {
            foreach ($value as $ky => $val) {
                $staff->school_classes()->attach($key, ['section_id' => $val, 'school_id' => request()->route()->school_id]);
            }
        }

        return redirect()->back();
    }

    public function assignClassesEdit($id)
    {
        $schoolClasses = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $staff = Staff::join('school_staff', 'staff.id', '=', 'school_staff.staff_id')->where('school_staff.school_id', request()->route()->school_id)->get();
        $staffWithClasses = $staff->filter(function ($s) {
            return $s->school_classes()->wherePivot('school_id', getSchool()->id)->get()->count();
        });
        $sections = Section::where('school_id', getSchool()->id)->get();
        $currentStaff = Staff::find($id);
        return view('vendors.staff.classes', compact('currentStaff', 'schoolClasses', 'staff', 'staffWithClasses', 'sections'));
    }

    public function assignSubjects()
    {
        $schoolClasses = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $staff = Staff::join('school_staff', 'staff.id', '=', 'school_staff.staff_id')->where('school_staff.school_id', request()->route()->school_id)->get();
        $staffWithClasses = $staff->filter(function ($s) {
            return $s->school_classes()->wherePivot('school_id', getSchool()->id)->get()->count();
        }); //Staff::join('school_staff', 'staff.id', '=', 'school_staff.staff_id')->where('school_staff.school_id',request()->route()->school_id)->get();
        $sections = Section::where('school_id', getSchool()->id)->get();
        return view('vendors.staff.subjects', compact('schoolClasses', 'staff', 'staffWithClasses', 'sections'));
    }

    public function assignSubjectsStore(Request $request)
    {
        $staff = Staff::find($request->staff);
        $class = $request->class;
        $staff->subjects()->wherePivot('school_id', getSchool()->id)
            ->wherePivot('school_class_id', $class)
            ->wherePivot('section_id', $request->section)->detach();
        $subjects = $request->subjects ?? [];
        foreach ($subjects as $sub) {
            $staff->subjects()->wherePivot('school_id', getSchool()->id)
                ->wherePivot('school_class_id', $class)
                ->wherePivot('section_id', $request->section)
                ->attach($sub, ['school_class_id' => $class, 'school_id' => request()->route()->school_id, 'section_id' => $request->section]);
        }

        return redirect()->back();
    }

    public function resetPassword(Request $request, Staff $staff)
    {
        $data = $this->validate($request, [
            'password' => 'required|string',
            // 'password_confirmation' => 'required|confirmed'
        ]);
        $staff->update(['password' => bcrypt($request->password)]);
        return redirect()->back()->with('message', 'Password was change');
    }
}
