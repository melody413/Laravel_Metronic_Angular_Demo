<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataForm;
use App\Models\InsuranceCompany;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class AInsuranceCompanyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Insurance Company','route' => 'admin.insurance_company']);
    }

    public function index(Request $request)
    {
        $insurance_companies = InsuranceCompany::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('insurance_companies');

        return response(['insurance_companies' => $insurance_companies], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $parent_branches = DataForm::getParentLab();
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        return response(['parent_branches' => $parent_branches, "country"=> $countries], 200);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);
        $item = InsuranceCompany::findOrFail($id);
        return response(compact('item'), 200);

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
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            }
            $row = InsuranceCompany::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            }else{
                $postData['image'] = '';
            }
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
    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('insurance_companies');
            $insurance_companies = InsuranceCompany::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $insurance_companies], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $insurance_companies = InsuranceCompany::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('insurance_companies');
            
            return response(['search_result' => $insurance_companies], 200);
        }
    }
}
