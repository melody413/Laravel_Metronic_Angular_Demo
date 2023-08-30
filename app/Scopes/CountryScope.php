<?php

namespace App\Scopes;

use App\Http\Controllers\Frontend\BaseController;
use App\Mangers\SettingsManger;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\http\Request;

class CountryScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        list($subdomain, $lang) = handleLangCountryDomain();


        if ($subdomain == env('ADMIN_PREFIX') || $subdomain == env('API_PREFIX') || \Request::segment(2) == 'data' || \Request::segment(1) == 'blog' || \Request::input('area'))
            return;

        if (in_array('country_id', $model->fillable)) {
            $builder->where('country_id', SettingsManger::Instance()->getCountry()->id);
        }

    }

}