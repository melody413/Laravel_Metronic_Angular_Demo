<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminRegistered
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
        $user = User::all();
        if(count($user) == 0){
            return $next($request);
        }else{
            return redirect()->back();
        }

    }
}
