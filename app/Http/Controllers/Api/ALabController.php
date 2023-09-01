<?php

namespace App\Http\Controllers\Api;

use App\Models\Lab;
use App\Models\LabCompany;
use App\Models\LabService;
use App\Models\Country;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class ALabController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Lab','route' => 'admin.lab']);
    }

    public function index(Request $request)
    {
        $labs = Lab::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('labs');

        return response(['labs' => $labs], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $lab_companies = LabCompany::all();
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        $this->formData();
        $lab_services = LabService::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        return response(["lab_company"=> $lab_companies, "country"=>$countries, "lab_service"=>$lab_services]);
        // return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $this->formData();

        $item = Lab::findOrFail($id);
        $labServicesId = $item->labServices()->pluck('lab_service_id')->toArray();

        $insuranceCompanies = $item->insuranceCompanies()->listsTranslations('name')->pluck('name','id')->toArray();
        return response(['item' => $item, 'labServicesId'=> $labServicesId, 'insuranceCompanies' => $insuranceCompanies], 200);
        // return view($this->getTemplatePath('edit'), ['item' => $item, 'labServicesId'=> $labServicesId, 'insuranceCompanies' => $insuranceCompanies]);
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
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            }
            $row = Lab::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            }else{
                $postData['image'] = "";
            }
            $row = Lab::create($postData);
        }

        if($request->has('lab_services'))
        {
            $row->LabServices()->sync($postData['lab_services']);
        }

        if($request->has('insurance_company_ids'))
        {
            $row->insuranceCompanies()->sync($postData['insurance_company_ids']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'labs/');
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
            return response(['next' => 'saveNew'], 200);
            // return redirect(route('admin.lab.create'))->with($redirctMsg);

        return response(['next' => 'list'], 200);
        // return redirect(route('admin.lab.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Lab::findOrFail($id);
        $row->delete();
        return response([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ], 200);
        // return redirect(route('admin.lab.index'))->with([
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
        return 'lab';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('labs');
            $labs = Lab::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $labs], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $labs = Lab::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('labs');
            
            return response(['search_result' => $labs], 200);
        }
    }
}
