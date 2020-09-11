<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request;
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
        if (! $request->expectsJson()) { //if not rigester in admin table (not Auth)
            if (Request::is('admin/*')) //if Route admin/* but not Auth or not rigester in admin table
            return route('admin.login');// redirect to admin.login
            else

           return route('login'); // redirect to user.login
          
        }
    }
}
