<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class ACountryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Country','route' => 'admin.country']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( Country::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    $row->code,
                    $row->currency_code,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.country.edit', ['id' => $row->id]],
                        //'copy' => ['admin.country.copy', ['id' => $row->id]],
                        'delete' => ['admin.country.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();


        return response(["result" => $data], 200);

    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return response(['action_title' => 'Create'], 200);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Country::findOrFail($id);
        return response(['item' => $item], 200);

    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
            'code' => 'required|max:255',
        ]);

        if($id)
        {
            $row = Country::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            } else {
                $postData['image'] = '';
            }
            $row = Country::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'countrys/');
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
        $row = Country::findOrFail($id);
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
        $row = Country::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.country.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/
    public function getAllCity($id){
        $query = "SELECT city_id, name 
                  FROM (SELECT * FROM city_trans WHERE locale='ar' ) as city_name 
                  INNER JOIN  ( SELECT id FROM cities WHERE country_id = :id AND is_active = 1 ) as city_id 
                  ON city_name.city_id = city_id.id";

        $queryParams = array('id' => $id);
          
        // Execute the query and retrieve the cities
        $cities = DB::select($query, $queryParams);
        return response(["city" => $cities]);

        // Return the cities
    }
    public function getTemplateFolder()
    {
        return 'country';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) use ($searchIndex) {
                $query->select(
                        'countries.*',
                        'country_trans.NAME AS arname'
                    )
                    ->from('countries')
                    ->join('country_trans', 'countries.id', '=', 'country_trans.country_id')
                    ->where('country_trans.locale', 'ar');
            }, 'result1')
            ->join('country_trans', 'result1.id', '=', 'country_trans.country_id')
            ->select(
                'result1.*',
                'country_trans.NAME AS enname'
            )
            ->where('country_trans.locale', 'en')
            ->orderByRaw('created_at DESC');
            
            $results = $query->where(function($query) use ($searchIndex) {
                $query->where('result1.arname', 'LIKE', "%$searchIndex%")
                      ->orWhere('country_trans.NAME', 'LIKE', "%$searchIndex%");
            })->get();
            
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [           
                    $row->id,
                    $row->arname,
                    $row->enname,
                    $row->code,
                    $row->currency_code,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.country.edit', ['id' => $row->id]],
                        //'copy' => ['admin.country.copy', ['id' => $row->id]],
                        'delete' => ['admin.country.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
            
        }else{

            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $query = DB::table(function ($query){
                $query->select(
                        'countries.*',
                        'country_trans.NAME AS arname'
                    )
                    ->from('countries')
                    ->join('country_trans', 'countries.id', '=', 'country_trans.country_id')
                    ->where('country_trans.locale', 'ar');
            }, 'result1')
            ->join('country_trans', 'result1.id', '=', 'country_trans.country_id')
            ->select(
                'result1.*',
                'country_trans.NAME AS enname'
            )
            ->where('country_trans.locale', 'en')
            ->orderByRaw('created_at DESC')
            ->limit($pageSize) // Set the number of records per page
            ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page

            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    $row->arname,
                    $row->enname,
                    $row->code,
                    $row->currency_code,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.country.edit', ['id' => $row->id]],
                        //'copy' => ['admin.country.copy', ['id' => $row->id]],
                        'delete' => ['admin.country.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
        }
    }
}
