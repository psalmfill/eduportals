<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::where('school_id',getSchool()->id)->get();

        return view('staff.sections', compact('sections'));
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
        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('sections')->where('school_id',getSchool()->id),
            ]
        ]);
        $data['school_id'] =request()->route()->school_id;
        if (Section::create($data)) {
            return redirect()->back()->with('message', 'Section Created successfully');
        }

        return redirect()->back()->with('error', 'Fail creating section');
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
        $section = Section::findOrFail($id);
        $sections = Section::where('school_id',getSchool()->id)->get();
        return view('staff.sections', compact('section', 'sections'));
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
        $data = $request->validate([
            'name' => [
                'required',
                Rule::unique('sections')->where('school_id',getSchool()->id)->ignore($id),
            ]
        ]);

        $section = Section::findOrFail($id);
        $section->update($data);

        return redirect()->route('sections.index')->with('message', 'Section Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        if ($section->delete()) {
            return redirect()->route('sections.index')->with('message', 'Section Deleted');
        }
        return redirect()->route('sections.index')->with('error', 'Deletion failed');
    }
}
