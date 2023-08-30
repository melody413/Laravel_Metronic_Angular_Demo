<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Lab;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class LabController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.lab.index'),
            'city',
            'area',
            'labServices',
            'insurance',
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
        $page_title = 'Labs';

        $rows = searchManger()
            ->of( Lab::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithLabService()
            ->filterWithInsuranceCompany()
            ->filterWithName()
            //->filterWithInsuranceCompany()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        if(\Request::segment(1) == "eg")
            $page_title = getMainModuleTitle('lab',$city, $area);
        else 
            $page_title = getMainModuleTitle('lab_gulf',$city, $area);

        $qanswers_qanswer_ids = \App\Models\QanswerSpecialty::where('specialty_id', $request->input('speciality', null))->pluck("qanswer_id")->toArray();
        //dd($qanswers_qanswer_ids[0]);
        $qanswers_ar = \App\Models\QanswerTrans::whereIn('qanswer_id', $qanswers_qanswer_ids)->where('locale', 'ar')->get();

        return view($this->getTemplatePath('index'), compact(['rows', 'page_title', 'area', 'city', 'page_title', 'qanswers_ar']));
    }

    public function unit($id)
    {
        $row = Lab::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Row not found')
            );
        }

        $page_title =   trans('general.lab') . ' ' .$row->name;
        view()->share(['lab' => $row, 'page_title' => $page_title]);

        return view($this->getTemplatePath('unit'), compact(['row','page_title']));
    }

    protected function getTemplateFolder()
    {
        return 'lab';
    }
}
