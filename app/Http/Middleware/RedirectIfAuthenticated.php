<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (user()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            }
            if (user()->role_id == 3 or user() instanceof \App\Models\Staff) {

                return redirect()->route('staff.dashboard');
            }
            if (user() instanceof \App\Models\Student) {
                return redirect()->route('student.dashboard');
            };


            dd('ss');
            return redirect()->intended();; //redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
