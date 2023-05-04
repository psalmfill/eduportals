<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $school = getSchool();
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();
        if (!$generalSettings) {
            $generalSettings = new GeneralSetting();
            $generalSettings->school_id = getSchool()->id;
            $generalSettings->save();
        }
        return view('staff.general_settings', compact('school', 'generalSettings'));
    }

    public function saveSettings(Request $request)
    {
        $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();
        $school = getSchool();
        $school->address = $request->address;
        $school->email = $request->email;
        $school->phone_number = $request->phone_number;
        $school->name = $request->name;

        if ($request->logo) {
            //delete old logo if any
            if ($school->logo) {
                Storage::delete($school->logo);
            }
            $path = $request->file('logo')->store('public/images');
            $school->logo = $path;
        }
        if ($request->coat_of_arm) {
            //delete old coat_of_arm if any
            if ($generalSettings->coat_of_arm) {
                Storage::delete($generalSettings->coat_of_arm);
            }
            $path = $request->file('coat_of_arm')->store('public/images');
            $generalSettings->coat_of_arm = $path;
        }
        if ($request->stamp) {
            //delete old logo if any
            if ($generalSettings->school_stamp) {
                Storage::delete($generalSettings->school_stamp);
            }
            $path = $request->file('stamp')->store('public/images');
            $generalSettings->school_stamp = $path;
        }
        $generalSettings->current_session_id = $request->current_session;
        $generalSettings->current_term_id =$request->current_term;
        $generalSettings->date_format = $request->date_format;

        $school->save();
        $generalSettings->save();
        return redirect()->back()->with('message', 'Setting Saved');
    }
}
