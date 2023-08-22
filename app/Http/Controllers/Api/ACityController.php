<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class ACityController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'City','route' => 'admin.city']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( City::query() )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    $row->country->name,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.city.edit', ['id' => $row->id]],
                        //'copy' => route('admin.city.copy', ['id' => $row->id]),
                        'delete' => ['admin.city.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();
        return response(["result" => $data], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        $this->formData();

        return response(['action_title' => 'Create'], 200);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $this->formData();

        $item = City::findOrFail($id);

        return response(['item' => $item], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
            'country_id' => 'required',
        ]);

        if($id)
        {
            $row = City::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = City::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'citys/');
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
        $row = City::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function formData()
    {
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        return response(['countries' => $countries], 200);
    }

    /*public function copy($id)
    {
        $row = City::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.city.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/

    public function getTemplateFolder()
    {
        return 'city';
    }
}
