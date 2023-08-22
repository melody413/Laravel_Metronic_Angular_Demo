<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class ACountryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Country','route' => 'admin.country']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( Country::query() )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    $row->code,
                    $row->currency_code,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.country.edit', ['id' => $row->id]],
                        //'copy' => ['admin.country.copy', ['id' => $row->id]],
                        'delete' => ['admin.country.delete', ['id' => $row->id]]
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

        $item = Country::findOrFail($id);
        return response(['item' => $item], 200);

    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);

        if($id)
        {
            $row = Country::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Country::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'countrys/');
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
        $row = Country::findOrFail($id);
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
        $row = Country::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.country.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/

    public function getTemplateFolder()
    {
        return 'country';
    }
}
