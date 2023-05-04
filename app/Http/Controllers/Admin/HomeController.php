<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $vendors = Vendor::count();
        $schools = School::count();
        $students = Student::whereHas('school', function ($q) {
            return $q->where('active', 1);
        })->count();
        $parents = User::where('role_id', 4)->count();
        $staff = Staff::count();
        $pins = Pin::count();
        $vendorCategories = VendorCategory::count();
        $schoolCategories = SchoolCategory::count();
        $roles = Role::count();
        return view('admin.index', compact('vendors', 'schools', 'students', 'parents', 'pins', 'vendorCategories', 'schoolCategories', 'roles', 'staff'));
    }
}
