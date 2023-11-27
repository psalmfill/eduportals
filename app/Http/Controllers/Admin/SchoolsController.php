<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\School\Staff\SchoolClassesController;
use App\Http\Requests\CreateSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\User;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::all();
        return view('admin.schools', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SchoolCategory::all();
        $vendors = Vendor::all();
        return view('admin.create_edit_school', compact('categories', 'vendors'));
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
        $vendors = Vendor::all();
        $school = School::findOrFail($id);
        return view('admin.create_edit_school', compact('categories', 'vendors', 'school'));
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
}
