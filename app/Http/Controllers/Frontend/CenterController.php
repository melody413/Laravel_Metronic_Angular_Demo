<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Center;
use App\Models\Pharmacy;
use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Models\Tag;

class CenterController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.center.index'),
            'city',
            'area',
            'insurance',
            'speciality',
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
            ->of( Center::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithInsuranceCompany()
            ->filterWithSpeciality()
            ->filterWithName()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();
        $Speciality = Specialty::where('id', $request->input('speciality', null))->withTranslation()->first();
        $sub_cat = $request->input('sub_cat', null);

        $page_title = getMainModuleTitle('center',$city, $area,$Speciality,$sub_cat);
        $qanswers_qanswer_ids = \App\Models\QanswerSpecialty::where('specialty_id', $request->input('speciality', null))->pluck("qanswer_id")->toArray();
        //dd($qanswers_qanswer_ids[0]);
        $qanswers_ar = \App\Models\QanswerTrans::whereIn('qanswer_id', $qanswers_qanswer_ids)->where('locale', 'ar')->get();

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title', 'Speciality', 'sub_cat', 'qanswers_ar'));
    }

    public function unit($id)
    {
        $row = Center::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Center not found')
            );
        }
        $page_title = trans('general.center') . ' '.$row->name;
        $specialty = $row->specialties()->pluck('specialty_id');
        $tags = Tag::where('module_name', 'center')->get();

        view()->share(['center' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'Center' => route('frontend.center.index'),
            $row->name => '',
        ]);

        return view($this->getTemplatePath('unit'), compact(['row','tags', 'specialty']));
    }

    protected function getTemplateFolder()
    {
        return 'center';
    }
}
