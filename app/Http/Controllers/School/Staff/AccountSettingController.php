<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountSettingController extends Controller
{
    public function index()
    {
        $staff = $this->getStaff();
        return view('staff.account', compact('staff'));
    }

    public function updateProfile(Request $request)
    {
        $staff = $this->getStaff();
        $staff->update($request->all());

        return redirect()->back()->with('message', 'Profile was successfully updated');
    }

    public function changePassword(Request $request)
    {
        $request->validate(['password' => 'required|confirmed', 'old_password' => 'required']);
        $staff = $this->getStaff();
        if (!Hash::check($request->old_password, $staff->password))
            return redirect()->back()->with('error', 'Old password is incorrect');

        $staff->update(['password' => bcrypt($request->password)]);
        return redirect()->back()->with('message', 'Passward was successfully updated');
    }

    public function changeAvatar(Request $request)
    {
        $staff = $this->getStaff();
        if ($request->has('passport')) {
            if ($staff->image) {
                Storage::delete($staff->image);
            }
            $path = $request->file('passport')->store('public/avatars');
            $staff->image = $path;
        }
        if ($staff->save())
            return redirect()->back()->with('message', 'Picture updated successfully');
        return redirect()->back()->with('error', 'Could not update picture');
    }

    private function getStaff()
    {
        return auth()->user() ?? auth()->guard('staff')->user();
    }
}
