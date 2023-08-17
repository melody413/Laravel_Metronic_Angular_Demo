<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Admin\BaseController;
use App\Mangers\DataTableManger;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ADiseaseController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Disease','route' => 'admin.disease']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( Disease::query() )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    img_tag($row->image,'diseases/'),
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.disease.edit', ['id' => $row->id]],
                        //'copy' => ['admin.disease.copy', ['id' => $row->id]],
                        'delete' => ['admin.disease.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();
        return response($data, 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $diseases = Disease::all();

        return view($this->getTemplatePath('create'),['diseases' => $diseases]);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Disease::findOrFail($id);
        // $diseaseTypeIds = $item->disease_types()->pluck('disease_type_id')->toArray();
        $diseases = Disease::all();
        $diseases_parent = [];
        $bps_parent = [];
        $symps_parent = [];

        if($item->parent_ids)
            $diseases_parent = array_map('intval', json_decode($item->parent_ids, true));
        if($item->body_part_ids)
            $bps_parent = array_map('intval', json_decode($item->body_part_ids, true));

        if($item->symptom_ids)
            $symps_parent = array_map('intval', json_decode($item->symptom_ids, true));

        // dd($diseases_parent);
        return view($this->getTemplatePath('edit'), ['item' => $item,
        'diseases' => $diseases, 'diseases_parent' => $diseases_parent, 'bps_parent' => $bps_parent, 'symps_parent' => $symps_parent]);
    }

    public function store(Request $request)
    {
        if($request->parent_ids)
            $request->parent_ids = (implode(",", $request->parent_ids));

        if($request->body_part_ids)
            $request->body_part_ids = (implode(",", $request->body_part_ids));

        if($request->symptom_ids)
            $request->symptom_ids = (implode(",", $request->symptom_ids));

        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = Disease::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Disease::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('disease_types'))
        {
            $row->disease_types()->sync($postData['disease_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'diseases/');
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
            return redirect(route('admin.disease.create'))->with($redirctMsg);

        return redirect(route('admin.disease.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Disease::findOrFail($id);
        $row->delete();

        return redirect(route('admin.disease.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = Disease::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.disease.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'disease';
    }
}
