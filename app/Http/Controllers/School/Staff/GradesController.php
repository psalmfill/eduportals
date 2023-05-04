<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::where('school_id', getSchool()->id)->get();
        return view('staff.grades', compact('grades'));
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
                Rule::unique('grades')->where('school_id', getSchool()->id)
            ],
            'maximum_score' => [
                'required', 'integer',
                Rule::unique('grades')->where('school_id', getSchool()->id)
            ],
            'minimum_score' => [
                'required', 'integer',
                Rule::unique('grades')->where('school_id', getSchool()->id)
            ],
            'remark' => 'required|string'
        ]);
        $data['school_id'] = request()->route()->school_id;
        Grade::create($data);
        return redirect()->back();
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
        $grade = Grade::findOrFail($id);
        $grades = Grade::where('school_id', getSchool()->id)->get();
        return view('staff.grades', compact('grades', 'grade'));
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
                Rule::unique('grades')->where('school_id', getSchool()->id)->ignore($id)
            ],
            'maximum_score' => [
                'required', 'integer',
                Rule::unique('grades')->where('school_id', getSchool()->id)->ignore($id)
            ],
            'minimum_score' => [
                'required', 'integer',
                Rule::unique('grades')->where('school_id', getSchool()->id)->ignore($id)
            ],
            'remark' => 'required|string'
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();
        return redirect()->back()->with('message', 'Grade Deleted');
    }
}
