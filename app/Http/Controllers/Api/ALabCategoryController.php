<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\LabCategory;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class ALabCategoryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'LabCategory','route' => 'admin.lab_category']);
    }

    public function index(Request $request)
    {
        $lab_categories = LabCategory::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('lab_categories');

        return response(['lab_categories' => $lab_categories], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $this->formData();
        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);
        $this->formData();
        $item = LabCategory::findOrFail($id);
        $categories_parent = $item->lab_category;

        return view($this->getTemplatePath('edit'), compact('item', 'categories_parent'));
    }

    public function store(Request $request)
    {
        $request->body_parts_ids = "";

        $id = $request->item_id;
        $postData = $request->except('_token');
        // if($request->body_part_ids)
        //     $postData['body_parts_ids'] = (implode(",", $request->body_part_ids));
            // $request->body_parts_ids = (implode(",", $request->body_part_ids));

        // if($request->body_parts_ids)
        //     $postData['body_parts_ids'] = (implode(",", $request->body_parts_ids));

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
        ]);


        if($id)
        {
    // dd($postData);
            $row = LabCategory::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = LabCategory::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'lab_categories/');
            $row->image = $image;
            $row->save();
        }


        // if($request->has('insurance_category_ids'))
        // {
        //     $row->insuranceCategories()->sync($postData['insurance_category_ids']);
        // }

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
            return redirect(route('admin.lab_category.create'))->with($redirctMsg);

        return redirect(route('admin.lab_category.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = LabCategory::findOrFail($id);
        $row->delete();

        return redirect(route('admin.lab_category.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function formData()
    {
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        view()->share([
            'countries' => $countries
        ]);
    }

    public function getTemplateFolder()
    {
        return 'lab_category';
    }
}
