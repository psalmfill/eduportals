<?php

namespace App\Http\Controllers\School\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
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


    public function authenticate(Request $request)
    {
        $data = $request->only('username', 'password');
        // get staff with username or email
        $staff = Staff::where('username', $data['username'])->orWhere('email', $data['username'])->first();
        $data['username'] = $staff->username ?? $data['username'];
        if ($this->guard()->attempt($data)) {
            if (!user()->schools()->where('id', getSchool()->id)->first()) {
                return $this->logout()->with('error', 'You dont have the right to access this school');
            }
            return redirect()->intended(route('staff.dashboard'));
        } else {

            //check if the user is the school super user
            $data['email'] = $data['username'];
            unset($data['username']);

            if (Auth::guard('web')->attempt($data)) {
                if (user()->id = getSchool()->user_id) {
                    return redirect()->intended(route('staff.dashboard'));
                }
            }

            return  redirect()->route('staff.login.form')->with('error', 'Invalid username or password');
        }
    }

    public function logout()
    {
        $this->guard()->logout();
        Auth::logout();
        return  redirect()->route('staff.login.form');
    }

    protected function guard()
    {
        return Auth::guard('staff');
    }
}
