<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\LabService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LabServiceController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Lab Service','route' => 'admin.lab_service']);
    }

    public function index(Request $request)
    {
        $lab_services = LabService::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('lab_services');

        return view($this->getTemplatePath('index'), ['lab_services' => $lab_services]);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = LabService::findOrFail($id);
        $categories_parent = (explode(",",$item->lab_category));

        // return view($this->getTemplatePath('edit'), ['item' => $item]);
        return view($this->getTemplatePath('edit'), compact('item', 'categories_parent'));

    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');
        if($request->lab_category)
            $postData['lab_category'] = (implode(",", $request->lab_category));
// dd($postData);
        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
        ]);

        if($id)
        {
            $row = LabService::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = LabService::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'lab_services/');
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
            return redirect(route('admin.lab_service.create'))->with($redirctMsg);

        return redirect(route('admin.lab_service.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = LabService::findOrFail($id);
        $row->delete();

        return redirect(route('admin.lab_service.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = LabService::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.lab_service.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'lab_service';
    }
}
