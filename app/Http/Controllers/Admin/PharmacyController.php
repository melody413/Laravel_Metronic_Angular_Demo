<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Pharmacy;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PharmacyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Pharmacy','route' => 'admin.pharmacy']);
    }

    public function index(Request $request)
    {
        $pharmacies = Pharmacy::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('pharmacys');

        return view($this->getTemplatePath('index'), ['pharmacies' => $pharmacies]);
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
        $item = Pharmacy::findOrFail($id);

        $insuranceCompanies = $item->insuranceCompanies()->listsTranslations('name')->pluck('name','id')->toArray();

        return view($this->getTemplatePath('edit'), compact('item', 'insuranceCompanies'));
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

        if($postData['parent_id'] == 0)
            $postData['parent_id'] = null;
        if($id)
        {
            $row = Pharmacy::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Pharmacy::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'pharmacies/');
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
            return redirect(route('admin.pharmacy.create'))->with($redirctMsg);

        return redirect(route('admin.pharmacy.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Pharmacy::findOrFail($id);
        $row->delete();

        return redirect(route('admin.pharmacy.index'))->with([
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
        return 'pharmacy';
    }
}
