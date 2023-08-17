<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CityController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'City','route' => 'admin.city']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
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
                ->rows()
            ;


            return $data;
        }

        return view($this->getTemplatePath('index'));
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

        $item = City::findOrFail($id);

        return view($this->getTemplatePath('edit'), ['item' => $item]);
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
            return redirect(route('admin.city.create'))->with($redirctMsg);

        return redirect(route('admin.city.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = City::findOrFail($id);
        $row->delete();

        return redirect(route('admin.city.index'))->with([
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
