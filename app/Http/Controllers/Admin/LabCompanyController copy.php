<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\LabCompany;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LabCompanyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'LabCompany','route' => 'admin.lab_company']);
    }

    public function index(Request $request)
    {
        $lab_companies = LabCompany::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('lab_companies');

        return view($this->getTemplatePath('index'), ['lab_companies' => $lab_companies]);
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
        $item = LabCompany::findOrFail($id);
        $bps_parent = [];

        // if($item->body_parts_ids)
        //     $bps_parent = (explode(",", $item->body_parts_ids));
        //     // $bps_parent = array_map('intval', json_decode($item->body_parts_ids, true));

        return view($this->getTemplatePath('edit'), compact('item'));
    }

    public function store(Request $request)
    {
        $request->body_parts_ids = "";

        $id = $request->item_id;
        $postData = $request->except('_token');
        // if($request->body_part_ids)
        //     $postData['body_parts_ids'] = (implode(",", $request->body_part_ids));
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
            $row = LabCompany::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = LabCompany::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'lab_companies/');
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
            return redirect(route('admin.lab_company.create'))->with($redirctMsg);

        return redirect(route('admin.lab_company.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = LabCompany::findOrFail($id);
        $row->delete();

        return redirect(route('admin.lab_company.index'))->with([
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
        return 'lab_company';
    }
}
