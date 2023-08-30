<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    use AuthorizesRequests;

    public function handle($request, Closure $next)
    {
        if( Auth::user() && Auth::user()->canAdminLogin() )
            return $next($request);

        return redirect(env('ADMIN_PREFIX').'/login');
    }
}
