<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function showLoginForm()
    {

        return view('vendors.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->only('email', 'password');

        if ($this->guard()->attempt($data)) {

            return redirect()->intended(route('vendor.dashboard'));
        }
        return  redirect()->route('vendor.login.form')->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        $this->guard()->logout();
        Auth::logout();
        return  redirect()->route('vendor.login.form');
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
