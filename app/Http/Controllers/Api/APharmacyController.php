<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\BaseController;
use App\Mangers\DataTableManger;
use App\Models\Pharmacy;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;

use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\pharmacyCompany;

class APharmacyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Pharmacy','route' => 'admin.pharmacy']);
    }

    public function index(Request $request)
    {
        $pharmacies = Pharmacy::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('pharmacys');
        return response(['pharmacies' => $pharmacies], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $this->formData();
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        $pharmacyCos = pharmacyCompany::all();
        return response(['country' => $countries, 'pharmacyCo'=> $pharmacyCos,]);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);
        $this->formData();
        $item = Pharmacy::findOrFail($id);

        $insuranceCompanies = $item->insuranceCompanies()->listsTranslations('name')->pluck('name','id')->toArray();

        return response(['result' => compact('item', 'insuranceCompanies')], 200);
        // return view($this->getTemplatePath('edit'), compact('item', 'insuranceCompanies'));
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

        if($postData['parent_id'] < 0)
            $postData['parent_id'] = null;

        if($id)
        {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            }
            $row = Pharmacy::findOrFail($id);
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
            return response(['next' => 'saveNew'], 200);
            // return redirect(route('admin.pharmacy.create'))->with($redirctMsg);
        return response(['next' => 'list'], 200);
        // return redirect(route('admin.pharmacy.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Pharmacy::findOrFail($id);
        $row->delete();
        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
        // return redirect(route('admin.pharmacy.index'))->with([
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
        return 'pharmacy';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('pharmacies');
            $pharmacies = Pharmacy::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $pharmacies], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;

            $pharmacies = Pharmacy::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('pharmacys');
            return response(['search_result' => $pharmacies], 200);

            
        }
    }
}
