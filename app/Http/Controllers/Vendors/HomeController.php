<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use App\Models\School;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;

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
}
