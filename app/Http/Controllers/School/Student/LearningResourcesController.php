<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\LearningResource;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class LearningResourcesController extends Controller
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
            $class =  SchoolClass::where('id', request()->class)->where('school_id', getSchool()->id)->first();
            $subject =  Subject::where('id', request()->subject)->where('school_id', getSchool()->id)->first();
            $learningResources = LearningResource::when($class, function ($query, $class) {
                return $query->where('school_class_id', $class->id);
            })
                ->when($subject, function ($query, $subject) {
                    return $query->where('subject_id', $subject->id);
                })
                ->where('school_id', getSchool()->id)
                ->orderBy('title', 'desc')->paginate();
            return view('student.learning-resources', compact('classes', 'learningResources', 'class', 'subjects', 'subject'));
        }
        $learningResources = LearningResource::where('school_id', getSchool()->id)->orderBy('created_at', 'desc')->paginate(100);
        return view('student.learning-resources', compact('classes', 'learningResources', 'subjects'));
    }

    public function show($id)
    {
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();

        if (!$learningResource) {
            abort(404);
        }
        return view('student.show_learning_resource', compact('learningResource'));
    }

    public function getDownload($id)
    {
        $learningResource = LearningResource::where('id', $id)->where('school_id', getSchool()->id)->first();

        //PDF file is stored under project/public/download/info.pdf
        $file = storage_path('app/' . $learningResource->file);

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file);
    }
}
