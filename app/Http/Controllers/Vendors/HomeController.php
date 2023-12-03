<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use App\Models\School;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {

        $schools = School::where('vendor_id', user()->vendor->id)->count();
        $students = Student::whereHas('school', function ($q) {
            return $q->where('active', 1)->where('vendor_id', user()->vendor->id);
        })->count();
        $staff = Staff::whereHas('schools', function ($q) {
            return $q->where('vendor_id', user()->vendor->id);
        })->count();
        $pins = Pin::whereHas('school', function ($q) {
            return $q->where('vendor_id', user()->vendor->id);
        })->count();
        return view('vendors.index', compact('schools', 'students', 'pins', 'staff'));
    }
    public function account()
    {
        $user = user();
        return view('vendors.account', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = user();
        $user->update($request->all());

        return redirect()->back()->with('message', 'Profile was successfully updated');
    }

    public function changePassword(Request $request)
    {
        $request->validate(['password' => 'required|confirmed', 'old_password' => 'required']);
        $staff = user();
        if (!Hash::check($request->old_password, $staff->password))
            return redirect()->back()->with('error', 'Old password is incorrect');

        $staff->update(['password' => bcrypt($request->password)]);
        return redirect()->back()->with('message', 'Passward was successfully updated');
    }
}
