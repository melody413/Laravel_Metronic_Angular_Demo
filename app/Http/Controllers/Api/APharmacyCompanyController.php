<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Admin\BaseController;
use App\Mangers\DataTableManger;
use App\Models\PharmacyCompany;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class APharmacyCompanyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'PharmacyCompany','route' => 'admin.pharmacy_company']);
    }

    public function index(Request $request)
    {
        $pharmacy_companies = PharmacyCompany::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('pharmacy_companies');

        return response(['pharmacy_companies' => $pharmacy_companies], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $this->formData();
        return response(['action_title' => 'crate'], 200);
        // return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);
        $this->formData();
        $item = PharmacyCompany::findOrFail($id);
        $bps_parent = [];

        // if($item->body_parts_ids)
        //     $bps_parent = (explode(",", $item->body_parts_ids));
            // $bps_parent = array_map('intval', json_decode($item->body_parts_ids, true));
        return response(['result' => compact('item')], 200);
        // return view($this->getTemplatePath('edit'), compact('item'));
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
            $row = PharmacyCompany::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = PharmacyCompany::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'pharmacy_companies/');
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
            return response(['next' => "saveNew"], 200);
            // return redirect(route('admin.pharmacy_company.create'))->with($redirctMsg);


        return response(['next' => 'list']);
        // return redirect(route('admin.pharmacy_company.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = PharmacyCompany::findOrFail($id);
        $row->delete();
        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success' ,
        ], 200);    
        // return redirect(route('admin.pharmacy_company.index'))->with([
        //     'flash_message' => trans('admin.delete_success_message') ,
        //     'flash_type' => 'success' ,
        // ]);
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
        return 'pharmacy_company';
    }
}
