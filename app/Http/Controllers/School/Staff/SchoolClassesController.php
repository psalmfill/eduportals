<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolClassesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school_classes = SchoolClass::where('school_id', request()->route()->school_id)->whereNotIn('name', ['Alumni', 'Trash'])->get();
        $sections = Section::where('school_id', request()->route()->school_id)->get();

        return view('staff.classes', compact('school_classes', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('school_classes')->where('school_id', request()->route()->school_id)
            ],
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id'
        ]);
        $class = SchoolClass::create([
            'name' => $request->name,
            'school_id' => request()->route()->school_id,
            'active' => 1
        ]);
        if ($class) {
            $class->sections()->sync($request->sections);
            return redirect()->route('classes.index')->with('message', 'class created');
        }
        return redirect()->route('classes.index')->with('error', 'failed to create class');
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
        $school_classes = SchoolClass::where('school_id', request()->route()->school_id)->get();
        $sections = Section::where('school_id', request()->route()->school_id)->get();
        $school_class = SchoolClass::findOrFail($id);
        return view('staff.classes', compact('school_classes', 'sections', 'school_class'));
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
        $request->validate([
            'name' => [
                'required',
                Rule::unique('school_classes')->where('school_id', request()->route()->school_id)->ignore($id)
            ],
            'sections' => 'required|array',
            'sections.*' => 'exists:sections,id'
        ]);
        $class = SchoolClass::findOrFail($id);
        $class->update([
            'name' => $request->name,
        ]);
        if ($class) {
            $class->sections()->sync($request->sections);
            return redirect()->route('classes.index')->with('message', 'class updated');
        }
        return redirect()->route('classes.index')->with('error', 'failed to update class');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->sections()->detach();
        if ($class->delete()) {
            return redirect()->route('classes.index')->with('message', 'class Deleted');
        }
        return redirect()->route('classes.index')->with('error', 'Deletion failed');
    }

    public function subjects()
    {
        $school_classes = SchoolClass::where('school_id', getSchool()->id)->whereNotIn('name', ['Alumni', 'Trash'])->with('sections', 'sections.subjects')->orderBy('name', 'asc')->get();
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        return view('staff.class.subjects', compact('school_classes', 'subjects'));
    }

    public function subjectsAssign(Request $request)
    {
        $class = SchoolClass::findOrFail($request->class);
        if (!$request->sections)
            return redirect()->back()->with('error', 'Please select at least one section');

        foreach ($request->sections as $section) {

            $class->subjects()->wherePivot(
                'school_id',
                request()->route()->school_id
            )->wherePivot('section_id', $section)->detach();


            $subjects = $request->subjects ?? [];
            foreach ($subjects as $subject) {

                $class->subjects()->attach($subject, [
                    'section_id' => $section,
                    'school_id' => request()->route()->school_id
                ]);
            }
        }

        return redirect()->back();
    }

    public function createAlumniAndTrashClasses($school)
    {

        // check and create alumni class and trash class for students
        $alumniClass = SchoolClass::where('school_id', $school->id)->where('name', 'Alumni')->first();
        if (!$alumniClass)
            $school->school_classes()->create(['name' => 'Alumni']);
        $trashClass = SchoolClass::where('school_id', $school->id)->where('name', 'Trash')->first();

        if (!$trashClass)
            $school->school_classes()->create(['name' => 'Trash']);

        return true;
    }
}
