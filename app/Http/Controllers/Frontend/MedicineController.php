<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Country;
use App\Models\Medicine;
use App\Models\MedicinesCategory;
use App\Models\QanswerMedicineCategory;
use App\Models\MedicinesCompanyTrans;
use App\Models\MedicinesScNameTrans;
use App\Models\MedicinesScName;
use App\Models\Pharmacy;
use App\Models\Tag;
use Illuminate\Http\Request;

class MedicineController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.medicine.index'),
            // 'scientific_name',
            // 'company',
            'category',
            'form',
            'name'
        ];

        // $city = $request->input('city',0);
        // if($city)
        // {
        //     $vars['areas'] = dataForm()->getAreas($city);
        // }

        view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $rows = searchManger()
            ->of( Medicine::query() )
            ->filterWithMedicineCategory()
            ->filterWithMedicineCompany()
            ->filterWithMedicineForm()
            ->filterWithMedicineScientificName1()
            ->filterWithName()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();
        $category = MedicinesCategory::where('id', $request->input('category', null) )->withTranslation()->first();
        $category_id = $request->input('category', null);
        $scientific_name_1_old = $request->input('scientific_name_1', null);
        if($scientific_name_1_old)
            return redirect()->to('/eg/medicines?scientific-name-1='.$scientific_name_1_old);

        $scientific_name_1 = $request->input('scientific-name-1', null);
        $parent = null;
        $parent2 = null;
        $page_title = getMainModuleTitle('medicines',$city, $area);
        if ($category_id){
            $parent = \App\Models\MedicinesCategory::find(\App\Models\MedicinesCategory::find($category->id)->parent);
            if($parent)
                $parent2 = \App\Models\MedicinesCategory::find(\App\Models\MedicinesCategory::find($parent->id)->parent);

        }
        // dd($parent);
        $qanswers_qanswer_ids = \App\Models\QanswerMedicineCategory::where('medicines_category_id', $request->input('category', null))->pluck("qanswer_id")->toArray();
        // dd($qanswers_qanswer_ids);
        $qanswers_ar = \App\Models\QanswerTrans::whereIn('qanswer_id', $qanswers_qanswer_ids)->where('locale', 'ar')->get();
        $scientific_name_1_title = MedicinesScName::where('id', $request->input('scientific-name-1', null) )->withTranslation()->first();
        
        if($scientific_name_1_title)
            $page_title = getMainModuleTitleWithoutIn('medicines',$scientific_name_1_title, $area);
            // dd($scientific_name_1);
        $form = $request->input('form', null);

        if($category)
            if($form)
                $page_title = getMainModuleTitle($form.'_medicines',$city,$area,\App\Models\MedicinesCategory::find($category_id) ?: $category );
            else
                $page_title = getMainModuleTitle('medicines',$city,$area,\App\Models\MedicinesCategory::find($category_id) ?: $category );


        $company_id = $request->input('company', null);

        $medicines_company_ar = null;
        if($company_id){
            $medicines_company_ar = MedicinesCompanyTrans::where('medicines_company_id',$company_id)->where('locale','ar')->first();
            $page_title = getMainModuleTitleWithoutIn('medicines_company',$medicines_company_ar, $area);
        }
        
        $country_code = \App\Mangers\SettingsManger::Instance()->getCountry()->code;

        $country = \App\Mangers\SettingsManger::Instance()->getCountry()->country->name;

        return view($this->getTemplatePath('index'), compact('rows', 'form', 'country', 'medicines_company_ar', 'company_id', 'category', 'qanswers_ar', 'category_id', 'city', 'area', 'page_title', 'parent', 'parent2', 'scientific_name_1_title'));
    }
    
    public function indexForClinic(Request $request)
    {
        $medicines = Medicine::all();

        $data = [
            "draw" => 0,
            "recordsTotal" => 1,
            "recordsFiltered" => 1,
            "data" => $medicines->take(50)->all(),
            "input" => [ ]
            ];
        // [
        //     "status" => "200",
        //     "details" => $medicines->take(50)->all()
        // ];
        // dd(json_encode($data));

        return $data ;

        return view($this->getTemplatePath('index'), [$medicines]);
    }
    public function medicines_company($id, Request $request)
    {
        $rows = searchManger()
            ->of( Medicine::where('company', $id) )
            ->filterWithMedicineCompany()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('medicines',$city, $area);

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function medicines_sc_name($id, Request $request)
    {
        $rows = searchManger()
            ->of( Medicine::where('company', $id) )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithInsuranceCompany()
            ->filterWithName()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('medicines',$city, $area);

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function unit($id, Request $request)
    {
        $row = Medicine::where('is_active', 1)->where('id',$id)->first();
        $country_code = \App\Mangers\SettingsManger::Instance()->getCountry()->code;
        // $country_id = $row->country_id;
        $cats = (explode(",",$row->category));

        $categories = \App\Models\MedicinesCategory::where('is_active' , 1)->whereIn('id', $cats)->orderBy('id', 'desc')->get();
        $show_all = \DB::table('medicines')->where("id",$id)->first()->show_all;
        if($show_all){
            $row = \DB::table('medicines')->where("id",$id)->first();
            $row->name = \DB::table('medicine_trans')->where("medicine_id",$id)->first()->name;
            $row->excerpt = \DB::table('medicine_trans')->where("medicine_id",$id)->first()->excerpt;
            $row->description = \DB::table('medicine_trans')->where("medicine_id",$id)->first()->description;
            // $row->title = \DB::table('medicine_trans')->where("medicine_id",$id)->first()->title;
            // $row->country_id = $country_id;

        //    dd($row->excerpt );
        }
        // dd($row);

        // dd($show_all);

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Medicine not found')
            );
        }

        $page_title = trans('general.medicine') . ' ' . $row->name;

        view()->share(['medicine' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'Medicine' => route('frontend.medicine.index'),
            $row->name => '',
        ]);
        $currency_code = Country::find($row->country_id)->currency_code;
        $country = Country::find($row->country_id)->name;
        // dd($country);
        $medicines_company_ar=""; $medicines_company_en="";
        if(isset($row->company) && $row->company){
            // $medicines_company = MedicinesCompanyTrans::where('medicines_company_id',$row->company)->first()->medicines_company_id;
            $medicines_company_ar = MedicinesCompanyTrans::where('medicines_company_id',$row->company)->where('locale','ar')->first()->name;
            $medicines_company_en = MedicinesCompanyTrans::where('medicines_company_id',$row->company)->where('locale','en')->first()->name;
        }
        $medicines_sc_name_1_ar=""; $medicines_sc_name_2_ar=""; $medicines_sc_name_3_ar="";
        $medicines_sc_name_1_en=""; $medicines_sc_name_2_en=""; $medicines_sc_name_3_en="";
        if(isset($row->scientific_name_1) && $row->scientific_name_1){
            $medicines_sc_name_1_ar = MedicinesScNameTrans::where('medicines_sc_name_id',$row->scientific_name_1)->where('locale','ar')->first()->name;
            $medicines_sc_name_1_en = MedicinesScNameTrans::where('medicines_sc_name_id',$row->scientific_name_1)->where('locale','en')->first()->name;
        }
        if(isset($row->scientific_name_2) && $row->scientific_name_2){
            $medicines_sc_name_2_ar = MedicinesScNameTrans::where('medicines_sc_name_id',$row->scientific_name_2)->where('locale','ar')->first()->name;
            $medicines_sc_name_2_en = MedicinesScNameTrans::where('medicines_sc_name_id',$row->scientific_name_2)->where('locale','en')->first()->name;
        }
        if(isset($row->scientific_name_3) && $row->scientific_name_3){
            $medicines_sc_name_3_ar = MedicinesScNameTrans::where('medicines_sc_name_id',$row->scientific_name_3)->where('locale','ar')->first()->name;
            $medicines_sc_name_3_en = MedicinesScNameTrans::where('medicines_sc_name_id',$row->scientific_name_3)->where('locale','en')->first()->name;
        }
        $tags = Tag::where('module_name', 'doctor')->get();
        $parent = null;
        $parent2 = null;

        $category = $categories->first();
        if ($category){
            $parent = \App\Models\MedicinesCategory::find(\App\Models\MedicinesCategory::find($category->id)->parent);
            if($parent)
                $parent2 = \App\Models\MedicinesCategory::find(\App\Models\MedicinesCategory::find($parent->id)->parent);

        }

        $related_medicines = Medicine::where('is_active', 1)
                            ->where('scientific_name_1',$row->scientific_name_1)
                            ->Where('scientific_name_2',$row->scientific_name_2)
                            ->Where('scientific_name_3',$row->scientific_name_3)
                            ->inRandomOrder()->get()->take(10);

                            //dd($related_medicines);
        // $categories = explode(",", $row->category);
        // dd($categories);
        return view($this->getTemplatePath('unit'), compact(['row', 'category', 'parent', 'parent2', 'tags', 'categories', 'cats', 'country', 'currency_code', 'country_code','medicines_company_ar','medicines_sc_name_1_ar','medicines_sc_name_2_ar','medicines_sc_name_3_ar','medicines_company_en','medicines_sc_name_1_en','medicines_sc_name_2_en','medicines_sc_name_3_en', 'related_medicines']));
    }

    protected function getTemplateFolder()
    {
        return 'medicine';
    }
}
