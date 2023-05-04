<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories  = VendorCategory::all();
        return view('admin.vendor_categories', compact('categories'));
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
            'name' => 'required|unique:vendor_categories'
        ]);
        try {
            VendorCategory::create($data);
            return redirect()->back()->with('message', 'Category successfully created');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed creating category');
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
        $category = VendorCategory::findOrFail($id);
        $categories = VendorCategory::all();
        return view('admin.vendor_categories', compact('categories', 'category'));
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
                Rule::unique('vendor_categories')->ignore($id)
            ]
        ]);
        try {
            $category = VendorCategory::findOrFail($id);
            $category->update($data);
            return redirect()->route('vendor-categories.index')->with('message', 'Category successfully created');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed creating category');
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
            $category = VendorCategory::findOrFail($id)->delete();
            return redirect()->back()->with('message', 'Category successfully deleted');

        }catch(Exception $e){
            return redirect()->back()->with('error', 'Failed to delete category');

        }
    }
}
