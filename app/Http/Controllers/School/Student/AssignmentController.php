<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $student = user();
        $assignments = Assignment::where('school_id', getSchool()->id)
            ->where('school_class_id', $student->school_class_id)
            ->where('section_id', $student->section_id)
            ->whereDate('available_date', '<=', now())
            ->paginate();
        return view('student.assignments', compact('assignments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignment = Assignment::where('id', $id)->where('school_id', getSchool()->id)->first();

        if (!$assignment) {
            abort(404);
        }
        return view('student.show_assignment', compact('assignment'));
    }
}
