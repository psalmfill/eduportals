<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    public function classSMS(Request $request)
    {
        $user = user();
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Trash'])->get();

        return view('staff.sms.classes', compact('classes'));
    }

    public function compose(Request $request)
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Trash'])->get();
        $class_id = $request->class;
        $section_id = $request->section;

        $currentClass = SchoolClass::find($class_id);
        $currentSection = Section::find($section_id);
        $sections =  $currentClass->sections;

        $students = Student::where('school_id', getSchool()->id)
            ->where('school_class_id', $class_id)
            ->where('section_id', $section_id)
            ->get();

        $phone_numbers = User::where('role_id', 4)->whereHas('children', function ($q) use ($class_id, $section_id) {
            $q->where('school_id', getSchool()->id)
                ->where('school_class_id', $class_id)
                ->where('section_id', $section_id);
        })->pluck('phone_number')->toArray();
        return view('staff.sms.classes', compact(
            'students',
            'classes',
            'sections',
            'currentClass',
            'currentSection',
            'phone_numbers',
        ));
    }

    public function send(Request $request)
    {
        // todo check if school has sms unit

        // todo deduct sms unit for the total phone numbers and message sieze

        // todo schedult and send sms to the phone number

        // todo return success message for sending sms
    }
}
