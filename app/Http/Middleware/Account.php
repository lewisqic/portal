<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class Account
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $app_user = app('app_user');
        $app_user->load('member');

        return $next($request);
    }
}
