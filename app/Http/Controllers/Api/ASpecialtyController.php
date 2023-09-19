<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class ASpecialtyController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Specialty','route' => 'admin.specialty']);
    }

    public function index(Request $request)
    {
        $data = dataTable()
            ->of( Specialty::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',

                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.specialty.edit', ['id' => $row->id]],
                        //'copy' => ['admin.specialty.copy', ['id' => $row->id]],
                        'delete' => ['admin.specialty.delete', ['id' => $row->id]]
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

        $item = Specialty::findOrFail($id);

        return response(['item' => $item], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255',
        ]);

        if($id)
        {
            $row = Specialty::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Specialty::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'specialtys/');
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
        $row = Specialty::findOrFail($id);
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    /*public function copy($id)
    {
        $row = Specialty::findOrFail($id);

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.specialty.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }*/

    public function getTemplateFolder()
    {
        return 'specialty';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) use ($searchIndex) {
                $query->select(
                        'specialties.*',
                        'specialty_trans.NAME AS arname'
                    )
                    ->from('specialties')
                    ->join('specialty_trans', 'specialties.id', '=', 'specialty_trans.specialty_id')
                    ->where('specialty_trans.locale', 'ar');
            }, 'result1')
            ->join('specialty_trans', 'result1.id', '=', 'specialty_trans.specialty_id')
            ->select(
                'result1.*',
                'specialty_trans.NAME AS enname'
            )
            ->where('specialty_trans.locale', 'en')
            ->orderByRaw('created_at DESC');
            
            $results = $query->where(function($query) use ($searchIndex) {
                $query->where('result1.arname', 'LIKE', "%$searchIndex%")
                      ->orWhere('specialty_trans.NAME', 'LIKE', "%$searchIndex%");
            })->get();
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [           
                    $row->id,
                    $row->arname,
                    $row->enname,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.specialty.edit', ['id' => $row->id]],
                        'delete' => ['admin.specialty.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
            
        }else{

            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $query = DB::table(function ($query){
                $query->select(
                        'specialties.*',
                        'specialty_trans.NAME AS arname'
                    )
                    ->from('specialties')
                    ->join('specialty_trans', 'specialties.id', '=', 'specialty_trans.specialty_id')
                    ->where('specialty_trans.locale', 'ar');
            }, 'result1')
            ->join('specialty_trans', 'result1.id', '=', 'specialty_trans.specialty_id')
            ->select(
                'result1.*',
                'specialty_trans.NAME AS enname'
            )
            ->where('specialty_trans.locale', 'en')
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
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.specialty.edit', ['id' => $row->id]],
                        'delete' => ['admin.specialty.delete', ['id' => $row->id]]
                    ])
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
        }
    }
}
