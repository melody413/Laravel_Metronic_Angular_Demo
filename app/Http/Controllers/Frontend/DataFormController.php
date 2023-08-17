<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class DataFormController extends BaseController
{
    public function getCities(Request $request)
    {
        /*if( !$request->ajax() )
            dd('NO WAY');*/

        return dataForm()->getCities($request->route('country_id'));
    }

    public function getAreas(Request $request)
    {
        /*if( !$request->ajax() )
            dd('NO WAY');*/

        return dataForm()->getAreas($request->route('city_id'));
    }

    protected function getTemplateFolder()
    {
        // TODO: Implement getTemplateFolder() method.
    }
}
