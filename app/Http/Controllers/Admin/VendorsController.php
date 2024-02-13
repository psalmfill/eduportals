<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        $vendorCategories = VendorCategory::all();
        return view('admin.vendors', compact('vendors', 'vendorCategories'));
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
    public function store(CreateVendorRequest $request)
    {
        try {
            DB::beginTransaction();
            //created vendor admin
            $admin = new User();
            $admin->first_name = $request->admin_first_name;
            $admin->last_name = $request->admin_last_name;
            $admin->other_name = $request->admin_other_name;
            $admin->email = $request->admin_email;
            $admin->phone_number = $request->admin_phone_number;
            $admin->address = $request->admin_address;
            $admin->password = $request->password ? bcrypt($request->password) : bcrypt('12345678');
            $admin->role_id = 2;
            $admin->save();

            //create vendor
            $vendor = new Vendor();
            $vendor->name = $request->name;
            $vendor->code = $request->code;
            $vendor->email = $request->email;
            $vendor->address = $request->address;
            $vendor->country = $request->country;
            $vendor->state = $request->state;
            $vendor->phone_number = $request->admin_phone_number;
            $vendor->city = $request->city;
            $vendor->user_id = $admin->id;
            $vendor->vendor_category_id = $request->category;
            $vendor->save();

            DB::commit();
            return redirect()->back()->with('message', 'vendor created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'vendor creation fail');
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
        $vendor = Vendor::findOrFail($id);
        $vendors = Vendor::all();
        $vendorCategories = VendorCategory::all();
        return view('admin.vendors', compact('vendors', 'vendorCategories', 'vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVendorRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            //created vendor admin
            $admin = User::findOrFail($request->user_id);
            $admin->first_name = $request->admin_first_name;
            $admin->last_name = $request->admin_last_name;
            $admin->other_name = $request->admin_other_name;
            $admin->email = $request->admin_email;
            $admin->phone_number = $request->admin_phone_number;
            $admin->address = $request->admin_address;
            $admin->save();

            //create vendor
            $vendor = Vendor::findOrFail($id);
            $vendor->name = $request->name;
            $vendor->code = $request->code;
            $vendor->email = $request->email;
            $vendor->address = $request->address;
            $vendor->country = $request->country;
            $vendor->state = $request->state;
            $vendor->phone_number = $request->admin_phone_number;
            $vendor->city = $request->city;
            $vendor->vendor_category_id = $request->category;
            $vendor->save();

            DB::commit();
            return redirect()->back()->with('message', 'vendor updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'vendor update fail');
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
        //
    }

    public function resetPassword(Request $request, $id)
    {

        $user = User::findOrFail($id);
        ;
        $user->password = bcrypt('12345678');
        if ($user->save()) {
            return redirect()->back()->with('message', ' Password has been reset to 12345678 ----');
        }
        return redirect()->back()->with('error', 'Fail to reset password');
    }
}
