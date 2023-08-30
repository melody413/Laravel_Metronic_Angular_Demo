<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\MedicinesScName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MedicinesScNamesController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'MedicinesScName','route' => 'admin.medicines_sc_name']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = dataTable()
                ->of( MedicinesScName::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    return [
                        $row->id,
//                        img_tag($row->image,'medicines/'),
                        isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                        isset($row->translate('en')->name)?$row->translate('en')->name:'',
                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.medicines_sc_name.edit', ['id' => $row->id]],
                            //'copy' => ['admin.medicines_sc_name.copy', ['id' => $row->id]],
                            'delete' => ['admin.medicines_sc_name.delete', ['id' => $row->id]]
                        ])
                    ];
                })
                ->rows()
            ;

            return $data;
        }

        return view($this->getTemplatePath('index'));
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = MedicinesScName::findOrFail($id);
        //$medicineTypeIds = $item->medicine_types()->pluck('medicine_type_id')->toArray();

        return view($this->getTemplatePath('edit'), ['item' => $item ]);
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
            $row = MedicinesScName::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = MedicinesScName::create($postData);
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        if($request->input('saveNew'))
            return redirect(route('admin.medicines_sc_name.create'))->with($redirctMsg);

        return redirect(route('admin.medicines_sc_name.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = MedicinesScName::findOrFail($id);
        $row->delete();

        return redirect(route('admin.medicines_sc_name.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = MedicinesScName::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.medicines_sc_name.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'medicines_sc_name';
    }
}
