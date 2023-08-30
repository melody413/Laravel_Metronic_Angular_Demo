<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\MedicinesCategory;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class MedicinesCategoryController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.medicines_category.index'),
            'name'
        ];

        $city = $request->input('city',0);
        if($city)
        {
            $vars['areas'] = dataForm()->getAreas($city);
        }

        view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $rows = searchManger()
            ->of( MedicinesCategory::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithName()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('medicines_companies',$city, $area);

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function unit($id)
    {
        $row = MedicinesCategory::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('MedicinesCategory not found')
            );
        }

        $page_title = trans('general.medicines_category') . ' ' . $row->name;

        view()->share(['medicines_category' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'MedicinesCategory' => route('frontend.medicines_category.index'),
            $row->name => '',
        ]);

        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'medicines_category';
    }
}
