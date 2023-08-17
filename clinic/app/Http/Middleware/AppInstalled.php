<?php

namespace App\Http\Middleware;

use Closure;

class AppInstalled
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
        if(config('app.has_installed') == 1){
            return $next($request);
        }else{
            return redirect()->to('/install');
        }

    }
}
