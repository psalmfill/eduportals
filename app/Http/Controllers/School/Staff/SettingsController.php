<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

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
        try {
            DB::beginTransaction();

            $generalSettings = GeneralSetting::where('school_id', getSchool()->id)->first();
            $school = getSchool();
            $school->address = $request->address;
            $school->email = $request->email;
            $school->phone_number = $request->phone_number;
            $school->name = $request->name;

            if ($request->logo) {
                //delete old logo if any
                if ($school->logo) {
                   if (Storage::exists($school->logo)) {
                    Storage::delete($school->logo);
                }
                }
                $logoDestination = $request->file('logo')->store('public/images');
                $school->logo = $logoDestination;
            }
            if ($request->coat_of_arm) {
                //delete old coat_of_arm if any
                if ($generalSettings->coat_of_arm) {
                    if (Storage::exists($generalSettings->coat_of_arm)) {
                    Storage::delete($generalSettings->coat_of_arm);
                }
                }
                $coatOfArmDestination = $request->file('coat_of_arm')->store('public/images');
                $generalSettings->coat_of_arm = $coatOfArmDestination;
            }
            if ($request->stamp) {
                //delete old logo if any
                if ($generalSettings->school_stamp) {
                   if (Storage::exists($generalSettings->school_stamp)) {
                    Storage::delete($generalSettings->school_stamp);
                }
                }
                $stampDestination = $request->file('stamp')->store('public/images');
                $generalSettings->school_stamp = $stampDestination;
            }
            $oldSchoolBackdropImage = null;
            $backdropImageDestination = null;

            if ($request->backdrop_image) {
                $oldSchoolBackdropImage = $generalSettings->backdrop_image;
                $backdropImage = $request->file('backdrop_image');
                $backdropImageName = time() . Str::random() . '.' . $backdropImage->getClientOriginalExtension();
                $backdrop_image = Image::make($backdropImage->getRealPath());
                $backdrop_image->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode();
                $path = Storage::disk('public')->put('images/' . $backdropImageName, $backdrop_image);
                $backdropImageDestination = 'public/images/' . $backdropImageName;
                $generalSettings->backdrop_image = $backdropImageDestination;
            }

            $generalSettings->current_session_id = $request->current_session;
            $generalSettings->current_term_id = $request->current_term;
            $generalSettings->date_format = $request->date_format;
            $generalSettings->slogan = $request->slogan;
            $generalSettings->tagline = $request->tagline;

            $school->save();
            $generalSettings->save();
            // delete the old images

            if ($oldSchoolBackdropImage and Storage::exists($oldSchoolBackdropImage)) {
                Storage::delete($oldSchoolBackdropImage);
            }
            DB::commit();

            return redirect()->back()->with('message', 'Setting Saved');
        } catch (Exception $e) {
            DB::rollback();
            if (isset($logoDestination)) {
                if (Storage::exists($logoDestination)) {
                    Storage::delete($logoDestination);
                }
            }
            if (isset($coatOfArmDestination)) {
                if (Storage::exists($coatOfArmDestination)) {
                    Storage::delete($coatOfArmDestination);
                }
            }
            if (isset($stampDestination)) {
                if (Storage::exists($stampDestination)) {
                    Storage::delete($stampDestination);
                }
            }
            if (isset($backdropImageDestination)) {
                if (Storage::exists($backdropImageDestination)) {
                    Storage::delete($backdropImageDestination);
                }
            }
            return redirect()->back()->with('error', 'Could not Update Settings ');
        }
    }
}
