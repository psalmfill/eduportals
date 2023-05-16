<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Expenditure;
use App\Models\Fee;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $staffCount = School::find(getSchool()->id)->staff()->count();
        $studentCount = Student::where('school_id', getSchool()->id)->whereHas('school_class', function ($q) {
            return $q->whereNotIn('name', ['Alumni', 'Trash']);
        })->active()->count();
        $subjectCount =
            Subject::where('school_id', getSchool()->id)->count();
        $sectionCount = Section::where('school_id', getSchool()->id)->count();
        $classCount = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->count();
        $totalExpenditure = Expenditure::where('school_id', getSchool()->id)->sum('amount', 0);
        $totalFee = Fee::where('school_id', getSchool()->id)->sum('amount', 0);

        return view('staff.home', compact(
            'staffCount',
            'studentCount',
            'subjectCount',
            'classCount',
            'sectionCount',
            'totalExpenditure',
            'totalFee',
        ));
    }
}
