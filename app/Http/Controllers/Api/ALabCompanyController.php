<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Mangers\DataTableManger;
use App\Models\LabCompany;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class ALabCompanyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'LabCompany','route' => 'admin.lab_company']);
    }

    public function index(Request $request)
    {
        $lab_companies = LabCompany::search($request->q)->orderByRaw('created_at DESC')->paginate(15)->fragment('lab_companies');
        return response(['lab_companies' => $lab_companies], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $this->formData();
        return response(['action_title' => 'Create'], 200);
        // return view($this->getTemplatePath('create'));
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

        // if($request->input('saveNew'))
        //     return redirect(route('admin.lab_company.create'))->with($redirctMsg);

        // return redirect(route('admin.lab_company.index'))->with($redirctMsg);
        
        if($request->input('saveNew'))
            return response(['next' => "savenew"]);

        return response(['id' => $row->id], 200);
    }

    public function delete($id)
    {
        $row = LabCompany::findOrFail($id);
        $row->delete();
        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
        // return redirect(route('admin.lab_company.index'))->with([
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
        return 'lab_company';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('lab_companies');
            $lab_companies = LabCompany::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $lab_companies], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $lab_companies = LabCompany::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('lab_companies');
            
            return response(['search_result' => $lab_companies], 200);
        }
    }
}
