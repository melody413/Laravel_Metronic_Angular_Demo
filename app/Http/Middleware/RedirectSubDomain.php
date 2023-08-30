<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Frontend\BaseController;
use App\Mangers\SettingsManger;
use App\Models\Country;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class RedirectSubDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $except = ['_debugbar', 'uploads', 'ar', 'en', 'data'];
        $segment1 = \Request::segment(1);

        if ($segment1 == null)
            return Redirect::to(env('FULL_DEFAULT_DOMAIN'));

        list($subdomain, $lang) = handleLangCountryDomain();

        $codes = SettingsManger::Instance()->getCountries()->pluck('code')->toArray();

        if (!in_array($subdomain, $codes) && $subdomain != env('ADMIN_PREFIX') && $subdomain != env('API_PREFIX') && !in_array($segment1, $except)) {
            return Redirect::to(env('FULL_DEFAULT_DOMAIN'));
        }

        $request->attributes->add(['subdomain' => $subdomain]);
        $request->attributes->add(['lang' => $lang]);

        return $next($request);
    }
}