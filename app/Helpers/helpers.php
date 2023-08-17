<?php

use \Illuminate\Support\Facades\Auth;

if (! function_exists('img_tag')){
    function img_tag(...$params){

        if ( array_key_exists('1', $params) )
        {
            $params['src'] = $params[0];
            $params['path'] = $params[1];
            $params['w'] = isset($params[2])?$params[2]:100;
            $params['h'] = isset($params[3])?$params[3]:100;
        }
        else
        {
            $params = $params[0];
            $params['w'] = isset($params['w'])?$params[2]:200;
            $params['h'] = isset($params['h'])?$params[3]:200;
        }

        $params['alt'] = isset($params['alt'])?$params['alt']:null;

        if ( empty($params['src']) )
            return '<img src="'. url('/assets/frontend/images/general/doctorak_default_logo_img.png/' ) . '" width="' . $params['w'] . '" height="'. $params['h'].'" alt="'. $params['alt'] .'" />';

        return '<img src="'. url('uploads/' . $params['path'] .'/'. $params['src'] ) . '" width="' . $params['w'] . '" height="'. $params['h'].'" alt="'. $params['alt'] .'" />';
    }
}


if (! function_exists('table_actions')){
    function table_actions($actions = array()){
        $acts = '';

        if ( array_key_exists('edit', $actions) && Gate::allows($actions['edit'][0]) )
        {
            $acts .= ' <a href="'. route($actions['edit'][0], $actions['edit'][1]) .'" class="btn btn-sm btn-info waves-effect"><i class="material-icons">mode_edit</i> Edit</a> ';
            view()->share(['hasListAction' => 1]);
        }

        if ( array_key_exists('copy', $actions) && Gate::allows($actions['copy'][0] ) )
        {
            $acts .= ' <a href="'. route($actions['copy'][0], $actions['copy'][1]) .'" class="btn bg-orange waves-effect" onclick="return confirm(\'Are you sure?\')"><i class="material-icons">content_copy</i> Copy</a> ';
            view()->share(['hasListAction' => 1]);
        }

        if ( array_key_exists('delete', $actions) && Gate::allows($actions['delete'][0] ))
        {
            $acts .= ' <a href="'. route($actions['delete'][0], $actions['delete'][1]) .'" class="btn btn-sm btn-danger waves-effect" onclick="return confirm(\'Are you sure?\')"><i class="material-icons">delete</i> Delete</a> ';
            view()->share(['hasListAction' => true]);
        }

        if ( array_key_exists('doctor_rate', $actions) && Gate::allows($actions['doctor_rate'][0] ))
        {
            $acts .= ' <a href="'. route($actions['doctor_rate'][0], $actions['doctor_rate'][1]) .'" class="btn btn-sm btn-blue waves-effect" ><i class="material-icons">star</i> Doctor rate</a> ';
            view()->share(['hasListAction' => true]);
        }

        if ( array_key_exists('doctor_reservation', $actions) && Gate::allows($actions['doctor_reservation'][0] ))
        {
            $acts .= ' <a href="'. route($actions['doctor_reservation'][0], $actions['doctor_reservation'][1]) .'" class="btn btn-sm btn-blue waves-effect" ><i class="material-icons">star</i>reservation</a> ';
            view()->share(['hasListAction' => true]);
        }

        if ( array_key_exists('doctor_branch', $actions) && Gate::allows($actions['doctor_branch'][0] ))
        {
            $acts .= ' <a href="'. route($actions['doctor_branch'][0], $actions['doctor_branch'][1]) .'" class="btn btn-sm btn-blue waves-effect" ><i class="material-icons">star</i> Doctor Branches</a> ';
            view()->share(['hasListAction' => true]);
        }

        return $acts;
    }
}

if (! function_exists('dataTable')){
    function dataTable(){
        return new \App\Mangers\DataTableManger(\Illuminate\Http\Request::capture());
    }
}

if (! function_exists('searchManger')){
    function searchManger(){
        return new \App\Mangers\SearchManger(\Illuminate\Http\Request::capture());
    }
}

if (! function_exists('locationManger')){
    function dataForm(){
        return \App\Mangers\DataForm::Instance();
    }
}


if (! function_exists('f_assets')){
    function f_assets($path){
        return '/assets/frontend/' . $path;
    }
}

if (! function_exists('breadcrumb')){
    function breadcrumb($breadcrumb){
        view()->share(['breadcrumb' => $breadcrumb]);
    }
}

if (! function_exists('get_option')){
    function get_option($key, $default = ''){
        return \App\Mangers\SettingsManger::Instance()->get_option($key, $default);
    }
}

if (! function_exists('doctorReserve')){
    function doctorReserve($doctor, $startDate) {
        return new \App\Mangers\DoctorReservation($doctor, $startDate);
    }
}

if (! function_exists('doctorReservePerBranch')){
    function doctorReservePerBranch($doctor, $branch, $startDate) {
        return new \App\Mangers\DoctorReservation($doctor,$branch, $startDate);
    }
}


if (! function_exists('getCountry')){
    function getCountry() {
        return \App\Mangers\SettingsManger::Instance()->getCountry();
    }
}

if (! function_exists('aTag')){
    function aTag(...$params) {
        $a = '';
        if ( is_array($params) )
        {

        }
    }
}

if (! function_exists('getPageTitle')){
    function getMainModuleTitle(...$params) {
        $title =  trans('general.' . $params[0]) . ' ';

        if(/*$params[0] == 'doctors' &&*/ isset($params[4]))
            $title .= $params[4] . ' ';
        if(/*$params[0] == 'doctors' &&*/ isset($params[3]))
            $title .= $params[3]->name . ' ';

        $title .= trans('general.in') . ' ';

        if(isset($params[1]->name) || isset($params[2]->name))
        {
            if(isset($params[2]->name))
                $title .= $params[2]->name . ' ';
            if(isset($params[1]->name))
                $title .= $params[1]->name . '';

        }
        else
            $title .= getCountry()->country->name;


        return $title;
    }

    function getMainModuleTitleWithoutIn(...$params) {
        $title =  trans('general.' . $params[0]) . ' ';

        if(/*$params[0] == 'doctors' &&*/ isset($params[4]))
            $title .= $params[4] . ' ';
        if(/*$params[0] == 'doctors' &&*/ isset($params[3]))
            $title .= $params[3]->name . ' ';

        // $title .= trans('general.in') . ' ';

        if(isset($params[1]->name) || isset($params[2]->name))
        {
            if(isset($params[2]->name))
                $title .= $params[2]->name . ' ';
            if(isset($params[1]->name))
                $title .= $params[1]->name . '';

        }
        else
            $title .= getCountry()->country->name;


        return $title;
    }
}
if (! function_exists('handleLangCountryDomain')) {
    function handleLangCountryDomain()
    {
        $except = ['_debugbar', 'uploads', 'data'];
        $domain = \Request::segment(1);

        //check if sub domain has lang
        $subEx = explode('_', $domain);

        $subdomain = 'eg';
        $lang = 'ar';

        if(count($subEx) == 1)
        {
            $subdomain = $domain;
            $lang = 'ar';
        }
        else if(count($subEx) == 2)
        {
            $subdomain = $subEx[0];
            $lang = $subEx[1];
        }

        return [
            $subdomain,
            $lang
        ];
    }
}

if (! function_exists('getCountryLangUrl')){
    function getCountryLangUrl($country = null) {

        if(!$country)
            $country = App\Mangers\SettingsManger::Instance()->getCountry()->code;

        list($sub, $lang) = handleLangCountryDomain();
        if($lang == 'ar')
            return '/' . strtolower($country);

        return '/' . strtolower($country) . '_' . $lang;
    }
}

if (! function_exists('getLang')){
    function getLang() {
        list($sub, $lang) = handleLangCountryDomain();
        return  $lang;
    }
}




