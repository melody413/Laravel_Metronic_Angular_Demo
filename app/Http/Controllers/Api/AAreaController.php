<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Area;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class AAreaController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Area','route' => 'admin.area']);
    }

    public function index(Request $request)
    {

 
        //Doctor::with(['hospitals
        $data = dataTable()
            ->of( Area::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    $row->city->country->name,
                    $row->city->name,

                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.area.edit', ['id' => $row->id]],
                        //'copy' => ['admin.role.copy', ['id' => $row->id]],
                        'delete' => ['admin.area.delete', ['id' => $row->id]]
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

        $item = Area::findOrFail($id);
        $country = City::where('id', $item->city_id)->get();

        // $country =Country::where('city_id', $item->city_id)->get();
        return response(['item' => $item, 'country'=> $country], 200);
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
            $row = Area::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Area::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'areas/');
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
        $row = Area::findOrFail($id);
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function formData()
    {
        $countries = Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
        return response(['countries' => $countries], 200);

    }

    /*public function copy($id)
    {
        $row = Area::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.area.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/



    public function getTemplateFolder()
    {
        return 'area';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) use ($searchIndex) {
                $query->select(
                        'areas.*',
                        'area_trans.NAME AS arname'
                    )
                    ->from('areas')
                    ->join('area_trans', 'areas.id', '=', 'area_trans.area_id')
                    ->where('area_trans.locale', 'ar');
            }, 'result1')
            ->join('area_trans', 'result1.id', '=', 'area_trans.area_id')
            ->select(
                'result1.*',
                'area_trans.NAME AS enname'
            )
            ->where('area_trans.locale', 'en')
            ->orderByRaw('created_at DESC');
            
            $results = $query->where(function($query) use ($searchIndex) {
                $query->where('result1.arname', 'LIKE', "%$searchIndex%")
                      ->orWhere('area_trans.NAME', 'LIKE', "%$searchIndex%");
            })->get();
            $resultsArray = $results->toArray();
            // return $resultsArray;
            $transformedResults = array_map(function ($row) {
                $city = City::where('id' , $row->city_id)->get();
                $country = Country::where('id' , $city[0]['country_id'])->get();
                return [           
                    $row->id,
                    $row->arname,
                    $row->enname,
                    $city[0]['name'],
                    $country[0]['name'],
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.area.edit', ['id' => $row->id]],
                        //'copy' => route('admin.city.copy', ['id' => $row->id]),
                        'delete' => ['admin.area.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
            
        }else{

            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $query = DB::table(function ($query){
                $query->select(
                        'areas.*',
                        'area_trans.NAME AS arname'
                    )
                    ->from('areas')
                    ->join('area_trans', 'areas.id', '=', 'area_trans.area_id')
                    ->where('area_trans.locale', 'ar');
            }, 'result1')
            ->join('area_trans', 'result1.id', '=', 'area_trans.area_id')
            ->select(
                'result1.*',
                'area_trans.NAME AS enname'
            )
            ->where('area_trans.locale', 'en')
            ->orderByRaw('created_at DESC')
            ->limit($pageSize) // Set the number of records per page
            ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page
            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                $city = City::where('id' , $row->city_id)->get();
                $country = Country::where('id' , $city[0]['country_id'])->get();
                return [           
                    $row->id,
                    $row->arname,
                    $row->enname,
                    $city[0]['name'],
                    $country[0]['name'],
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.area.edit', ['id' => $row->id]],
                        //'copy' => route('admin.city.copy', ['id' => $row->id]),
                        'delete' => ['admin.area.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
        }
    }
}
