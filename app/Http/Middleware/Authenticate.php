<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        if (!$request->expectsJson()) {

            if ($request->is('student') || $request->is('student/*')) {
                return route('student.login.form', getSchool()->code);
            }

            if ($request->is('staff') || $request->is('staff/*')) {
                return route('staff.login.form', getSchool()->code);
            }


            if ($request->is('super-admin') || $request->is('super-admin/*')) {
                return route('admin.login.form');
            }



            return route('login');
        }
    }
}
