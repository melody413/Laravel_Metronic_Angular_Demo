<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Pharmacy;
use App\Models\Specialty;
use App\Models\Tag;
use Illuminate\Http\Request;

class HospitalController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.hospital.index'),
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
            ->of( Hospital::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithInsuranceCompany()
            ->filterWithSpeciality()
            ->filterWithName()
            ->paginate()
        ;

        $Speciality = Specialty::where('id', $request->input('speciality', null))->withTranslation()->first();
        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();
        $sub_cat = $request->input('sub_cat', null);
        $tag = Tag::where('id', $request->input('tag'))->withTranslation()->first();
        // if(isset($sub_cat)) {
        //     $Speciality = \App\Models\SubCategory::where('id', $sub_cat)->first()->name;
        // }
        $page_title = getMainModuleTitle('hospital',$city, $area,$Speciality,$sub_cat);
        $qanswers_qanswer_ids = \App\Models\QanswerSpecialty::where('specialty_id', $request->input('speciality', null))->pluck("qanswer_id")->toArray();
        // dd($qanswers_qanswer_ids);
        $qanswers_ar = \App\Models\QanswerTrans::whereIn('qanswer_id', $qanswers_qanswer_ids)->where('locale', 'ar')->get();
        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'Speciality', 'page_title', 'sub_cat', 'tag', 'qanswers_ar'));
    }

    public function unit($id)
    {
        $row = Hospital::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Hospital not found')
            );
        }

        $page_title =  trans('general.hospital') . ' ' .$row->name;
       // dd($row->specialties());
       // $specialty = Specialty::where('id', $row->specialties()->pluck('specialty_id')[0])->withTranslation()->first();
        $tags = Tag::where('module_name', 'hospital')->get();
        $specialty = $row->specialties()->pluck('specialty_id');

        view()->share(['hospital' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'Hospital' => route('frontend.hospital.index'),
            $row->name => '',
        ]);

        return view($this->getTemplatePath('unit'), compact(['row', 'tags', 'specialty']));
    }

    protected function getTemplateFolder()
    {
        return 'hospital';
    }
}
