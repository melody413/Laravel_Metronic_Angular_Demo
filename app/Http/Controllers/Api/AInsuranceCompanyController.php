<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\InsuranceCompany;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class AInsuranceCompanyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Insurance Company','route' => 'admin.insurance_company']);
    }

    public function index(Request $request)
    {
        $insurance_companies = InsuranceCompany::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('insurance_companies');

        return response(['insurance_companies' => $insurance_companies], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        return response(['action_title' => 'Create'], 200);

        // return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = InsuranceCompany::findOrFail($id);
        return response(['result' => compact('item', 'categories_parent')], 200);

        // return view($this->getTemplatePath('edit'), ['item' => $item]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
        ]);

        if($postData['parent_id'] == 0)
            $postData['parent_id'] = null;

        if($id)
        {
            $row = InsuranceCompany::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = InsuranceCompany::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'insurance_companies/');
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
        // if($request->input('saveNew'))
        //     return redirect(route('admin.insurance_company.create'))->with($redirctMsg);

        // return redirect(route('admin.insurance_company.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = InsuranceCompany::findOrFail($id);
        $row->delete();
        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
        // return redirect(route('admin.insurance_company.index'))->with([
        //     'flash_message' => trans('admin.delete_success_message') ,
        //     'flash_type' => 'success' ,
        // ]);
    }

    public function copy($id)
    {
        $row = InsuranceCompany::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();
        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
        // return redirect(route('admin.insurance_company.index'))->with([
        //     'flash_message' => trans('admin.copy_success_message') ,
        //     'flash_type' => 'success' ,
        // ]);
    }

    public function getTemplateFolder()
    {
        return 'insurance_company';
    }
}
