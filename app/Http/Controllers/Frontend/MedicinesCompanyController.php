<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\MedicinesCompany;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class MedicinesCompanyController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.medicines_company.index'),
            'name',
            'company'
        ];

        view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $rows = searchManger()
            ->of( MedicinesCompany::query() )
            ->filterWithMedicineCompany()
            ->paginate()
        ;

        $page_title = getMainModuleTitle('medicines_companies');

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function unit($id)
    {
        $row = MedicinesCompany::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('MedicinesCompany not found')
            );
        }

        $page_title = trans('general.medicines_company') . ' ' . $row->name;

        view()->share(['medicines_company' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'MedicinesCompany' => route('frontend.medicines_company.index'),
            $row->name => '',
        ]);

        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'medicines_company';
    }
}
