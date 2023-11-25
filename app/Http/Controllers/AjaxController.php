<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getClasses()
    {
        $user = user();
        if ($user instanceof Staff)
            $classes = $user->school_classes->unique();
        else
            $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->orderBy('name', 'desc')->get();

        return response()->json([
            'classes' => $classes
        ]);
    }

    public function getSectionsByClassId($id)
    {
        $user = user();
        if ($user instanceof Staff)
            $sections = SchoolClass::classSections($user->id, $id, getSchool()->id);
        else
            $sections = SchoolClass::find($id)->sections;

        return response()->json([
            'sections' => $sections
        ]);
    }
    public function getSectionsByClassName($name)
    {
        $sections = SchoolClass::where('name', $name)->where('school_id', getSchool()->id)->first()->sections;

        return response()->json([
            'sections' => $sections
        ]);
    }

    public function getStaffClasses($staff_id)
    {
        $staff = Staff::find($staff_id);
        return response()->json(
            $staff->school_classes()->wherePivot('school_id', getSchool()->id)->get()->unique()
        );
    }

    public function getStaffClassSections($id, $class_id)
    {
        $sections = Staff::classSections($id, $class_id, getSchool()->id);
        return response()->json(
            $sections
        );
    }

    public function getStaffClassSectionSubjects($id, $class_id, $section_id)
    {
        $staff = Staff::find($id);
        $subjects = $staff->subjects()->wherePivot('class_id', $class_id)
            ->wherePivot('section_id', $section_id)->get();
        return response()->json(
            $subjects
        );
    }
    public function getSectionStudents($class_id, $section_id)
    {
        $students = Student::where('school_class_id', $class_id)->where('section_id', $section_id)->get()->map(function ($i) {
            $i->full_name = $i->full_name;
            return $i;
        });
        return response()->json(
            $students
        );
    }

    public function getSubjectByClassSection($class_id, $section_id)
    {
        $section = Section::find($section_id);
        $user = user();
        if ($user instanceof Staff)
            $subjects = $user->subjects;
        else
            $subjects = $section->subjects()->wherePivot('school_class_id', $class_id)
                ->wherePivot('school_id', getSchool()->id)->get();
        return response()->json(
            $subjects
        );
    }

    public function getSchoolClasses($id)
    {

        $classes = SchoolClass::where('school_id', $id)->orderBy('name', 'desc')->whereNotIn('name', ['Alumni', 'Trash'])->get();

        return response()->json([
            'classes' => $classes
        ]);
    }
}
