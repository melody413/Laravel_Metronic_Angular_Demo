<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\MedicinesCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class AMedicinesCompanyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'MedicinesCompany','route' => 'admin.medicines_company']);
    }

    public function index(Request $request)
    {
        $data = dataTable()
            ->of( MedicinesCompany::query() )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
//                        img_tag($row->image,'medicines/'),
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.medicines_company.edit', ['id' => $row->id]],
                        //'copy' => ['admin.medicines_company.copy', ['id' => $row->id]],
                        'delete' => ['admin.medicines_company.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();

        return response(["result" => $data], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return response(['action_title' => 'Create'], 200);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = MedicinesCompany::findOrFail($id);
        //$medicineTypeIds = $item->medicine_types()->pluck('medicine_type_id')->toArray();
        return response(['item' => $item], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = MedicinesCompany::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = MedicinesCompany::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'medicines_company/');
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
            return response(['next' => "savenew"]);
        return response(['id' => $row->id], 200);
    }

    public function delete($id)
    {
        $row = MedicinesCompany::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = MedicinesCompany::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'medicines_company';
    }
}
