<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\MedicinesCategory;
use App\Models\SubCategory;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class AMedicinesCategoryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'MedicinesCategory','route' => 'admin.medicines_category']);
    }

    public function index(Request $request)
    {
        $medicines = MedicinesCategory::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('medicines');
        // dd($medicines);

        return response(["medicines" => $medicines], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $sub_categories = SubCategory::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        return response(['country' => $countries, 'sub_category'=> $sub_categories], 200);

    }
    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);
        $item = MedicinesCategory::findOrFail($id);

        // $categories_parent = [];
        // if($item->parent && str_contains($item->parent, ','))
        //     $categories_parent = json_decode($item->parent, true);
        //     // $categories_parent = array_map('intval', json_decode($item->parent, true));
        // else
        //     $categories_parent[] = ($item->parent);

        $item = MedicinesCategory::findOrFail($id);
        $categories_parent = (explode(",",$item->parent));
        $sub_categories = SubCategory::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
// dd($categories_parent);
        //$medicineTypeIds = $item->medicine_types()->pluck('medicine_type_id')->toArray();
        return response(['item' => $item, 'categories_parent'=> $categories_parent, 'country' => $countries, 'sub_category'=> $sub_categories], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');
// dd($request->parent);
        if($request->parent)
            $postData['parent'] = ($request->parent);

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);
        if($id)
        {
            $row = MedicinesCategory::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = MedicinesCategory::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'medicines_category/');
            $row->image = $image;
            $row->save();
        }

        if($request->has('image_delete'))
        {
            $row->image = '';
            $row->save();
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        return response(['id' => $row->id], 200);
    }

    public function delete($id)
    {
        $row = MedicinesCategory::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = MedicinesCategory::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'medicines_category';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('medicines_categories');
            $query->select('medicines_categories.*');
            $query->addSelect('medicines_category_trans.name as name');
            $query->join('medicines_category_trans', 'medicines_category_id', '=', 'medicines_categories.id');
            $query->where('medicines_category_trans.locale', '=', 'ar');
            $query->where('medicines_category_trans.name', 'LIKE', "%$searchIndex%");
            $medicines = $query->get();
            return response(['search_result' => $medicines], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;

            $medicines = MedicinesCategory::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('medicines');
            
            return response(['search_result' => $medicines], 200);

            
        }
    }
}
