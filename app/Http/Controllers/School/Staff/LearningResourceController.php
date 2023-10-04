<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\LearningResource;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class LearningResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        if (request()->query->count() > 1) {
            $class =  SchoolClass::where('name', request()->class)->where('school_id', getSchool()->id)->first();
            $subject =  Subject::where('id', request()->subject)->where('school_id', getSchool()->id)->first();
            $learningResources = LearningResource::when($class, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })->when($subject, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })->where('school_id', getSchool()->id)->orderBy('first_name', 'desc')->active()->paginate();
            $class_id = $class ? $class->id : null;
            return view('staff.learning-resources', compact('classes', 'learningResources', 'class_id', 'subjects', 'subject'));
        }
        $learningResources = LearningResource::where('school_id', getSchool()->id)->orderBy('created_at', 'desc')->paginate(100);
        return view('staff.learning-resources', compact('classes', 'learningResources', 'subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        return view('staff.create_edit_learning_resource', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
