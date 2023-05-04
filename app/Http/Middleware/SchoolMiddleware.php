<?php

namespace App\Http\Middleware;

use App\Models\School;
use Closure;
use Illuminate\Support\Facades\URL;

class SchoolMiddleware
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
        $subdomain = $request->route()->school;
        $request->route()->forgetParameter('school');

        URL::defaults(['school' => $subdomain]);
        $school = School::where('code', $subdomain)->first();
        if (!$school) {
            return redirect()->away(env('BASE_URL'));
        }


        $request->route()->school_id = $school->id;

        return $next($request);
    }
}
