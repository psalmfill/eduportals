<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SchoolCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = SchoolCategory::all();
        return view('admin.school_categories',compact('categories'));
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
            'name' => 'required|string|unique:school_categories'
        ]);
        try{
            SchoolCategory::create($data);
            return redirect()->back()->with('message','Category Created Successfully');
        }catch(Exception $e){
            return redirect()->back()->with('message','Category creation failed');
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
        $category = SchoolCategory::findOrfail($id);
        $categories = SchoolCategory::all();
        return view('admin.school_categories',compact('categories','category'));
      
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
                Rule::unique('school_categories')->ignore($id)
            ]
        ]);

        try{
            SchoolCategory::findOrFail($id)->update($data);
            return redirect()->back()->with('message','Category Updated Successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error','Category Update failed');
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
        try{
            SchoolCategory::findOrFail($id)->delete();
            return redirect()->route('school-categories.index')->with('message','Category deletes successfully');

        }catch(Exception $e){
            return redirect()->back()->with('error','Category Update failed');
            
        }
    }
}
