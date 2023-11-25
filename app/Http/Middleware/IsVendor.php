<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVendor
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

        if (user()->role_id != 2) {
            Auth::logout();
            return redirect()->route('vendor.login')->with('error', 'Vendors Access only!');
        }
        return $next($request);
    }
}
