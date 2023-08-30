<?php

namespace App\Http\Middleware;

use Closure;

class AssistantCheck
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
      if (auth()->user()->role == 2 || auth()->user()->role == 1) {
          return $next($request);
      } else {
          return redirect()->to('/access-denied');
      }
    }
}
