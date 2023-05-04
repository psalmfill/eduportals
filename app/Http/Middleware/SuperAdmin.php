<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
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

        if (user()->role_id != 1) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Super admin Access only!');
        }
        return $next($request);
    }
}
