<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use Okipa\LaravelTable\TableList;
use App\Models\Medicine;
use App\Models\MedicinesCategory;
use App\Models\MedicinesCompany;
use App\Models\MedicinesScName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use App\Models\BodyPart;
use Illuminate\Support\Facades\DB;

class AMedicineController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Medicine','route' => 'admin.medicine']);
    }

    public function index(Request $request)
    {
        $medicines = Medicine::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('medicines');
        // dd($medicines);
        return response(["medicines" => $medicines], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $companies = MedicinesCompany::all();
        $medicines_sc_names = MedicinesScName::all();
        $categories = MedicinesCategory::all();
        $bodyparts = BodyPart::all();
        return response(["result" => compact('companies', 'medicines_sc_names', 'categories', 'bodyparts')], 200);
        // return view($this->getTemplatePath('create'), compact('companies', 'medicines_sc_names', 'categories'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Medicine::findOrFail($id);
        //$medicineTypeIds = $item->medicine_types()->pluck('medicine_type_id')->toArray();
        $symps_parent = [];
        $bps_parent = [];

        if($item->body_part_ids)
            $bps_parent = $item->body_part_ids;


        if($item->symptom_ids)
            $symps_parent = array_map('intval', json_decode($item->symptom_ids, true));

        // $insuranceCompanies = $item->insuranceCompanies->pluck('name', 'id');
        $companies = MedicinesCompany::all();
        $categories = MedicinesCategory::all();
        $categories_parent = (explode(",",$item->category));
        // dd($categories_parent);
        // dd($categories_parent);module_name
        $medicines_sc_names = MedicinesScName::all();
        $drug_classes =  MedicinesCategory::all();
        $available_strengthes = MedicinesCategory::all();
        //dd($companies[0]->translate('ar')->name);
        return response(["result" => compact('item', 'bps_parent', 'symps_parent', 'drug_classes', 
        'available_strengthes','companies', 'medicines_sc_names', 'categories', 'categories_parent')], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;

        if($request->symptom_ids)
            $request->symptom_ids = (implode(",", $request->symptom_ids));

        $postData = $request->except('_token');
        if($request->category)
            $postData['category'] = (implode(",", $request->category));

        // dd($postData);
        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = Medicine::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Medicine::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'medicines/');
            $row->image = $image;
            $row->save();
        }

        if($request->has('image_delete'))
        {
            $row->image = '';
            $row->save();
        }

        // if($request->has('insurance_company_ids'))
        // {
        //     $row->insuranceCompanies()->sync($postData['insurance_company_ids']);
        // }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];


        if($request->input('saveNew'))
            return response(['next' => "savenew"]);

        return response(['id' => $row->id], 200);
    }

    public function delete($id)
    {
        $row = Medicine::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = Medicine::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();
        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'medicine';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('medicines');
            $medicines = Medicine::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $medicines], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $medicines = Medicine::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('medicines');
            
            return response(['search_result' => $medicines], 200);
        }
    }
}
