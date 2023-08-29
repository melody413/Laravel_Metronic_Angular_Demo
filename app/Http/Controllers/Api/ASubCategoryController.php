<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Mangers\DataTableManger;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class ASubCategoryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'SubCategory','route' => 'admin.sub_category']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( SubCategory::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    img_tag($row->image,'sub_categories/'),
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.sub_category.edit', ['id' => $row->id]],
                        //'copy' => ['admin.sub_category.copy', ['id' => $row->id]],
                        'delete' => ['admin.sub_category.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();

        return response(["result" => $data], 200);

    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $sub_categories = SubCategory::all();
        return response(['sub_categories' => $sub_categories], 200);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = SubCategory::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        // $sub_categoryTypeIds = $item->sub_category_types()->pluck('sub_category_type_id')->toArray();
        $sub_categories = SubCategory::all();
        $sub_categories_parent = [];
        if($item->parent)
            $sub_categories_parent = array_map('intval', json_decode($item->parent, true));

        // dd($sub_categories_parent);
        return response(['item' => $item, 'specialityIds'=> $specialityIds,
        'sub_categories' => $sub_categories, 'sub_categories_parent' => $sub_categories_parent], 200);
    }

    public function store(Request $request)
    {
        if($request->parent)
            $request->parent = (implode(",", $request->parent));

        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = SubCategory::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = SubCategory::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('sub_category_types'))
        {
            $row->sub_category_types()->sync($postData['sub_category_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'sub_categories/');
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
        $row = SubCategory::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = SubCategory::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'sub_category';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) use ($searchIndex) {
                $query->select(
                        'sub_categories.*',
                        'sub_category_trans.NAME AS arname'
                    )
                    ->from('sub_categories')
                    ->join('sub_category_trans', 'sub_categories.id', '=', 'sub_category_trans.sub_category_id')
                    ->where('sub_category_trans.locale', 'ar');
            }, 'result1')
            ->join('sub_category_trans', 'result1.id', '=', 'sub_category_trans.sub_category_id')
            ->select(
                'result1.*',
                'sub_category_trans.NAME AS enname'
            )
            ->where('sub_category_trans.locale', 'en')
            ->orderByRaw('created_at DESC');
            
            $results = $query->where(function($query) use ($searchIndex) {
                $query->where('result1.arname', 'LIKE', "%$searchIndex%")
                      ->orWhere('sub_category_trans.NAME', 'LIKE', "%$searchIndex%");
            })->get();
            
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    img_tag($row->image,'sub_categories/'),
                    $row->arname,
                    $row->enname,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.medicines_company.edit', ['id' => $row->id]],
                        'delete' => ['admin.medicines_company.delete', ['id' => $row->id]]
                    ]) 
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
            
        }else{

            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $query = DB::table(function ($query){
                $query->select(
                        'sub_categories.*',
                        'sub_category_trans.NAME AS arname'
                    )
                    ->from('sub_categories')
                    ->join('sub_category_trans', 'sub_categories.id', '=', 'sub_category_trans.sub_category_id')
                    ->where('sub_category_trans.locale', 'ar');
            }, 'result1')
            ->join('sub_category_trans', 'result1.id', '=', 'sub_category_trans.sub_category_id')
            ->select(
                'result1.*',
                'sub_category_trans.NAME AS enname'
            )
            ->where('sub_category_trans.locale', 'en')
            ->orderByRaw('created_at DESC')
            ->limit($pageSize) // Set the number of records per page
            ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page

            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    img_tag($row->image,'sub_categories/'),
                    $row->arname,
                    $row->enname,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.medicines_company.edit', ['id' => $row->id]],
                        'delete' => ['admin.medicines_company.delete', ['id' => $row->id]]
                    ]) 
                ];
            }, $resultsArray);
            return response(['search_result' => $transformedResults], 200);
        }
    }
}
