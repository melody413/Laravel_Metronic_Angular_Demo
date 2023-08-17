<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\MedicinesCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MedicinesCategoryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'MedicinesCategory','route' => 'admin.medicines_category']);
    }

    public function index(Request $request)
    {
        $medicines = MedicinesCategory::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('medicines');
        // dd($medicines);
        return view($this->getTemplatePath('index'), [/*$table,*/ "medicines" => $medicines]);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return view($this->getTemplatePath('create'));
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
// dd($categories_parent);
        //$medicineTypeIds = $item->medicine_types()->pluck('medicine_type_id')->toArray();
        return view($this->getTemplatePath('edit'), ['item' => $item, 'categories_parent'=> $categories_parent ]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');
// dd($request->parent);
        if($request->parent)
            $postData['parent'] = (implode(",", $request->parent));

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

        if($request->input('saveNew'))
            return redirect(route('admin.medicines_category.create'))->with($redirctMsg);

        return redirect(route('admin.medicines_category.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = MedicinesCategory::findOrFail($id);
        $row->delete();

        return redirect(route('admin.medicines_category.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = MedicinesCategory::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.medicines_category.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'medicines_category';
    }
}
