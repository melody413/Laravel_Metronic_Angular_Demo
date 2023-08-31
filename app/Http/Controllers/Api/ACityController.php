<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class ACityController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'City','route' => 'admin.city']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( City::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    $row->country->name,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.city.edit', ['id' => $row->id]],
                        //'copy' => route('admin.city.copy', ['id' => $row->id]),
                        'delete' => ['admin.city.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();
        return response(["result" => $data], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        $this->formData();

        return response(['action_title' => 'Create'], 200);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $this->formData();

        $item = City::findOrFail($id);

        return response(['item' => $item], 200);
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

        if($id)
        {
            $row = City::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = City::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'citys/');
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
    }

    public function delete($id)
    {
        $row = City::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function formData()
    {
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        return response(['countries' => $countries], 200);
    }

    /*public function copy($id)
    {
        $row = City::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.city.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/

    public function getTemplateFolder()
    {
        return 'city';
    }

    public function getAllArea($id){
        
        $query = "SELECT area_id, name 
                  FROM (SELECT * FROM area_trans WHERE locale='ar' ) as area_name 
                  INNER JOIN  ( SELECT id FROM areas WHERE city_id = :id AND is_active = 1 ) as area_id 
                  ON area_name.area_id = area_id.id";

        $queryParams = array('id' => $id);
          
        // Execute the query and retrieve the cities
        $areas = DB::select($query, $queryParams);
        return response(["area" => $areas]);

        // Return the cities
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) use ($searchIndex) {
                $query->select(
                        'cities.*',
                        'city_trans.NAME AS arname'
                    )
                    ->from('cities')
                    ->join('city_trans', 'cities.id', '=', 'city_trans.city_id')
                    ->where('city_trans.locale', 'ar');
            }, 'result1')
            ->join('city_trans', 'result1.id', '=', 'city_trans.city_id')
            ->select(
                'result1.*',
                'city_trans.NAME AS enname'
            )
            ->where('city_trans.locale', 'en')
            ->orderByRaw('created_at DESC');
            
            $results = $query->where(function($query) use ($searchIndex) {
                $query->where('result1.arname', 'LIKE', "%$searchIndex%")
                      ->orWhere('city_trans.NAME', 'LIKE', "%$searchIndex%");
            })->get();
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                $country = Country::where('id' , $row->country_id)->get();
                return [           
                    $row->id,
                    $row->arname,
                    $row->enname,
                    $country[0]['name'],
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.city.edit', ['id' => $row->id]],
                        //'copy' => route('admin.city.copy', ['id' => $row->id]),
                        'delete' => ['admin.city.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
            
        }else{

            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $query = DB::table(function ($query){
                $query->select(
                        'cities.*',
                        'city_trans.NAME AS arname'
                    )
                    ->from('cities')
                    ->join('city_trans', 'cities.id', '=', 'city_trans.city_id')
                    ->where('city_trans.locale', 'ar');
            }, 'result1')
            ->join('city_trans', 'result1.id', '=', 'city_trans.city_id')
            ->select(
                'result1.*',
                'city_trans.NAME AS enname'
            )
            ->where('city_trans.locale', 'en')
            ->orderByRaw('created_at DESC')
            ->limit($pageSize) // Set the number of records per page
            ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page

            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                $country = Country::where('id' , $row->country_id)->get();
                return [           
                    $row->id,
                    $row->arname,
                    $row->enname,
                    $country[0]['name'],
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.city.edit', ['id' => $row->id]],
                        //'copy' => route('admin.city.copy', ['id' => $row->id]),
                        'delete' => ['admin.city.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
        }
    }
}
