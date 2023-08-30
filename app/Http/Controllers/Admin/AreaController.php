<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Area;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AreaController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Area','route' => 'admin.area']);
    }

    public function index(Request $request)
    {

        if($request->ajax())
        {
            //Doctor::with(['hospitals
            $data = dataTable()
                ->of( Area::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    return [
                        $row->id,
                        isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                        isset($row->translate('en')->name)?$row->translate('en')->name:'',
                        $row->city->country->name,
                        $row->city->name,

                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.area.edit', ['id' => $row->id]],
                            //'copy' => ['admin.role.copy', ['id' => $row->id]],
                            'delete' => ['admin.area.delete', ['id' => $row->id]]
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

        $item = Area::findOrFail($id);

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
            $row = Area::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Area::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'areas/');
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
            return redirect(route('admin.area.create'))->with($redirctMsg);

        return redirect(route('admin.area.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Area::findOrFail($id);
        $row->delete();

        return redirect(route('admin.area.index'))->with([
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
        $row = Area::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.area.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/



    public function getTemplateFolder()
    {
        return 'area';
    }
}
