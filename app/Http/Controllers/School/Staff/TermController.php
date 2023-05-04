<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::where('school_id',getSchool()->id)->get();

        return view('staff.terms', compact('terms'));
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
                Rule::unique('terms')->where('school_id',getSchool()->id)
            ]
        ]);

        $data['school_id'] =request()->route()->school_id;
        $term = Term::create($data);
        if ($term) {
            return redirect()->back()->with('message', 'Term Created successfully');
        }

        return redirect()->back()->with('error', 'Fail creating Term');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = Term::findOrFail($id);
        $terms = Term::where('school_id',getSchool()->id)->get();
        return view('staff.terms', compact('term', 'terms'));
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
                Rule::unique('terms')->where('school_id',getSchool()->id)->ignore($id)
            ]
        ]);

        $term = Term::findOrFail($id);
        if ($term->update($data)) {
            return redirect()->route('terms.index')->with('message', 'Term updated successfully');
        }

        return redirect()->route('terms.index')->with('error', 'Fail updating term');
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
