<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class ACenterController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Center','route' => 'admin.center']);
    }

    public function index(Request $request)
    {
        // if($request->ajax())
        // {
        //     $data = dataTable()
        //         ->of( Center::query() )
        //         ->filterColumns(['id', 'slug'])
        //         ->each(function ($row) {
        //             return [
        //                 $row->id,
        //                 img_tag($row->image,'centers/'),
        //                 isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
        //                 isset($row->translate('en')->name)?$row->translate('en')->name:'',
        //                 date('d-m-Y', strtotime($row->updated_at)),
        //                 table_actions([
        //                     'edit' => ['admin.center.edit', ['id' => $row->id]],
        //                     //'copy' => ['admin.center.copy', ['id' => $row->id]],
        //                     'delete' => ['admin.center.delete', ['id' => $row->id]]
        //                 ])
        //             ];
        //         })
        //         ->rows()
        //     ;

        //     return $data;
        // }
        $centers = Center::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('centers');

        return response(["centers" => $centers], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Center::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        //$centerTypeIds = $item->center_types()->pluck('center_type_id')->toArray();

        $insuranceCompanies = $item->insuranceCompanies->pluck('name', 'id');

        return view($this->getTemplatePath('edit'), ['item' => $item, 'specialityIds'=> $specialityIds/*, 'centerTypeIds'=> $centerTypeIds*/, 'insuranceCompanies' => $insuranceCompanies]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($postData['parent_id'] == 0)
            $postData['parent_id'] = null;

        if($id)
        {
            $row = Center::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Center::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('center_types'))
        {
            $row->center_types()->sync($postData['center_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'centers/');
            $row->image = $image;
            $row->save();
        }

        if($request->has('image_delete'))
        {
            $row->image = '';
            $row->save();
        }

        if($request->has('image_gallery'))
        {
            $row->image_gallery = json_encode($postData['image_gallery']);
            $row->save();
        }

        if ($postData['image_gallery_count'] == 0)
        {
            $row->image_gallery = '';
            $row->save();
        }

        if($request->has('insurance_company_ids'))
        {
            $row->insuranceCompanies()->sync($postData['insurance_company_ids']);
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        if($request->input('saveNew'))
            return redirect(route('admin.center.create'))->with($redirctMsg);

        return redirect(route('admin.center.edit', ['id' => $row->id]))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Center::findOrFail($id);
        $row->delete();

        return redirect(route('admin.center.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = Center::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.center.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'center';
    }
}
