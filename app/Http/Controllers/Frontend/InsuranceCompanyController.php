<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;

class InsuranceCompanyController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.insurance_company.index'),
            'city',
            'area'
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
            ->of( InsuranceCompany::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('insurances_companies',$city, $area);

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function unit($id)
    {
        $row = InsuranceCompany::where('is_active', 1)->where('id',$id)->first();


        $docs = $row->doctors;

        if(!$row){
            return abort(404);

            throw(
                new \Exception('InsuranceCompany not found')
            );
        }
        $page_title = trans('general.insurances') . ' ' . $row->name;

        view()->share(['insurance_company' => $row, 'page_title' => $page_title]);

        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'insurance_company';
    }
}
