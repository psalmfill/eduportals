<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isSchoolSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (user()->id != getSchool()->user_id && !Auth::guard('staff')->user()) {
            Auth::logout();
            return redirect()->route('staff.login')->with('error', 'Restricted page! Access denied');
        }
        return $next($request);
    }
}
