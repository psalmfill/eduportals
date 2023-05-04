<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        return view('staff.subjects', compact('subjects'));
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
                Rule::unique('subjects')->where('school_id', getSchool()->id),
            ],
            'code' => [
                'required',
                Rule::unique('subjects')->where('school_id', getSchool()->id),
            ],
        ]);
        $data['school_id'] = request()->route()->school_id;
        if (Subject::create($data)) {
            return redirect()->back()->with('message', 'Subject Created successfully');
        }

        return redirect()->back()->with('error', 'Fail creating subject');
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
        $subject = Subject::findOrFail($id);
        $subjects = Subject::where('school_id', getSchool()->id)->get();
        return view('staff.subjects', compact('subject', 'subjects'));
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
                Rule::unique('subjects')->where('school_id', getSchool()->id)->ignore($id),
            ],
            'code' => [
                'required',
                Rule::unique('subjects')->where('school_id', getSchool()->id)->ignore($id),
            ],
        ]);
        if (Subject::findOrFail($id)->update($data)) {
            return redirect()->route('subjects.index')->with('message', 'Subject Updated successfully');
        }

        return redirect()->route('subjects.index')->with('error', 'Fail updating subject');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        if ($subject->delete()) {
            return redirect()->route('subjects.index')->with('message', 'subject Deleted');
        }
        return redirect()->route('subjects.index')->with('error', 'Deletion failed');
    }
}
