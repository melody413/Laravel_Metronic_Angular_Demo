<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Symptom;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SymptomController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Symptom','route' => 'admin.symptom']);
    }

    public function index(Request $request)
    {
        $symptoms = Symptom::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('symptoms');

        return view($this->getTemplatePath('index'), ['symptoms' => $symptoms]);
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
        $item = Symptom::findOrFail($id);
        $bps_parent = [];

        if($item->body_parts_ids)
            $bps_parent = (explode(",", $item->body_parts_ids));
            // $bps_parent = array_map('intval', json_decode($item->body_parts_ids, true));

        return view($this->getTemplatePath('edit'), compact('item', 'bps_parent'));
    }

    public function store(Request $request)
    {
        $request->body_parts_ids = "";

        $id = $request->item_id;
        $postData = $request->except('_token');
        if($request->body_part_ids)
            $postData['body_parts_ids'] = (implode(",", $request->body_part_ids));
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
            $row = Symptom::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Symptom::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'symptoms/');
            $row->image = $image;
            $row->save();
        }


        if($request->has('insurance_company_ids'))
        {
            $row->insuranceCompanies()->sync($postData['insurance_company_ids']);
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
            return redirect(route('admin.symptom.create'))->with($redirctMsg);

        return redirect(route('admin.symptom.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Symptom::findOrFail($id);
        $row->delete();

        return redirect(route('admin.symptom.index'))->with([
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
        return 'symptom';
    }
}
