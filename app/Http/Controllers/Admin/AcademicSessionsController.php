<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicSessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions = AcademicSession::all();
        return view('admin.academic_sessions', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'name' => 'required|unique:academic_sessions',
            'start_year' => 'required|digits:4',
            'end_year' => 'required|digits:4'
        ]);

        try {
            AcademicSession::create($data);
            return  redirect()->back()->with('message', 'Academic Session Created Successfully');
        } catch (Exception $e) {
            return  redirect()->back()->with('error', 'failed to create Academic Session.');
        }
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

        $sessions = AcademicSession::all();
        $session = AcademicSession::findOrFail($id);
        return view('admin.academic_sessions', compact('sessions', 'session'));
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
                Rule::unique('academic_sessions')->ignore($id)
            ],
            'start_year' => 'required|digits:4',
            'end_year' => 'required|digits:4'
        ]);

        try {
            AcademicSession::findOrFail($id)->update($data);
            return  redirect()->route('academic-sessions.index')->with('message', 'Academic Session updated Successfully');
        } catch (Exception $e) {
            return  redirect()->back()->with('error', 'failed to update Academic Session.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            AcademicSession::findOrFail($id)->delete();
            return  redirect()->route('academic-sessions.index')->with('message', 'Academic Session deleted Successfully');
        } catch (Exception $e) {
            return  redirect()->back()->with('error', 'failed to delete Academic Session.');
        }
    }
}
