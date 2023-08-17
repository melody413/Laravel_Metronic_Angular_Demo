<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.pharmacy.index'),
            'city',
            'area',
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
        $pharmacies = searchManger()
            ->of( Pharmacy::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithName()
            ->filterWithInsuranceCompany()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('pharmacy',$city, $area);
        $qanswers_qanswer_ids = \App\Models\QanswerSpecialty::where('specialty_id', $request->input('speciality', null))->pluck("qanswer_id")->toArray();
        //dd($qanswers_qanswer_ids[0]);
        $qanswers_ar = \App\Models\QanswerTrans::whereIn('qanswer_id', $qanswers_qanswer_ids)->where('locale', 'ar')->get();

        return view($this->getTemplatePath('index'), compact('pharmacies', 'area', 'city', 'page_title', 'qanswers_ar'));
    }

    public function unit($id)
    {
        $row = Pharmacy::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('row not found')
            );
        }
        $page_title =  $row->name; //trans('general.pharmacy') . ' ' .
        view()->share(['pharmacy' => $row, 'page_title' => $page_title]);

        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'pharmacy';
    }
}
