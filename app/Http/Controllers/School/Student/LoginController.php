<?php

namespace App\Http\Controllers\School\Student;

use App\Http\Controllers\Controller;
use App\Models\Pin;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function authenticate(Request $request)
    // {
    //     $data = $request->only('reg_no');

    //     //validate pin used
    //     $student = Student::where('reg_no', $request->reg_no)->first();
    //     $pin = Pin::where('code', $request->pin)->first();
    //     if (!$pin || !$student || $pin->school_id != getSchool()->id) {
    //         return redirect()->back()->with('error', 'Invalid Registration Number or Pin');
    //     }
    //     if ($pin->student_id != null && $pin->student_id != $student->id) {
    //         return redirect()->back()->with('error', 'Pin already in use by another student');
    //     }
    //     if (!$student->active)
    //         return redirect()->back()->with('error', 'Account is inactive, please contact school admin for clarification');

    //     if ($pin->expiry_date == null) {
    //         $pin->expiry_date = Carbon::now()->addDays($pin->duration);
    //         $pin->student_id = $student->id;
    //         $pin->activation_date = now();
    //         $pin->save();
    //     }

    //     if ($pin->has_expired) {
    //         return redirect()->back()->with('error', 'Pin number has expired, Get a new pin.');
    //     }

    //     if ($this->guard()->loginUsingId($student->id)) {
    //         return redirect()->intended(route('student.dashboard'));
    //     } else {
    //         return  redirect()->route('student.login.form');
    //     }
    // }

    public function login()
    {
        return view('student.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->only('reg_no', 'password');

        if ($this->guard()->attempt($data)) {

            return redirect()->intended(route('student.dashboard'));
        }
        return  redirect()->route('student.login.form')->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        $this->guard()->logout();
        return  redirect()->route('student.login.form');
    }

    protected function guard()
    {
        return Auth::guard('student');
    }

    public function username()
    {
        return 'reg_no';
    }
}
