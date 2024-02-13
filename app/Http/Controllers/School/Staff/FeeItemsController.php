<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFeeItemRequest;
use App\Http\Requests\UpdateFeeItemRequest;
use App\Models\FeeItem;
use Illuminate\Http\Request;

class FeeItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feeItems = FeeItem::orderBy('name')->get();
        return view("staff.finances.fee_items", compact("feeItems"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFeeItemRequest $request)
    {
        $feeItem = FeeItem::create(array_merge($request->all(),['school_id'=>getSchool()->id]));
        return redirect()->back()->with("message","Fee category created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $feeItems = FeeItem::orderBy('name')->get();
        $feeItem = FeeItem::find($id);
        return view("staff.finances.fee_items", compact("feeItems",'feeItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeItemRequest $request, string $id)
    {
        $feeItem = FeeItem::find($id)->update($request->all());
        return redirect()->back()->with("message","Fee category updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
