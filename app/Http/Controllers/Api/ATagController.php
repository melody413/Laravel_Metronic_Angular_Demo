<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class ATagController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Tag','route' => 'admin.tag']);
    }

    public function index(Request $request)
    {
        $data = dataTable()
            ->of( Tag::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    img_tag($row->image,'tags/'),
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.tag.edit', ['id' => $row->id]],
                        //'copy' => ['admin.tag.copy', ['id' => $row->id]],
                        'delete' => ['admin.tag.delete', ['id' => $row->id]]
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

        $item = Tag::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        //$tagTypeIds = $item->tag_types()->pluck('tag_type_id')->toArray();
        $categoryIds = $item->medicine_categories()->pluck('medicines_category_id')->toArray();
        return response(['item' => $item, 'specialityIds'=> $specialityIds, 'categoryIds'=> $categoryIds], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = Tag::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Tag::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('medicine_categories'))
        {
            $row->medicine_categories()->sync($postData['medicine_categories']);
        }

        if($request->has('tag_types'))
        {
            $row->tag_types()->sync($postData['tag_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'tags/');
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
        $row = Tag::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = Tag::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'tag';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) {
                $query->select(
                    'tags.*',
                    'tag_trans.NAME AS arname'
                )
                ->from('tags')
                ->join('tag_trans', 'tags.id', '=', 'tag_trans.tag_id')
                ->where('tag_trans.locale', 'ar');
            }, 'result1')
            ->join('tag_trans', 'result1.id', '=', 'tag_trans.tag_id')
            ->select(
                'result1.*',
                'tag_trans.NAME AS enname'
            )
            ->where('tag_trans.locale', 'en')->orderByRaw('created_at DESC');
            $results = $query->where('arname', 'LIKE', "%$searchIndex%"); 

            $results = $query->get();
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    img_tag($row->image,'tags/'),
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

            $query = DB::table(function ($query) {
                $query->select(
                    'tags.*',
                    'tag_trans.NAME AS arname'
                )
                ->from('tags')
                ->join('tag_trans', 'tags.id', '=', 'tag_trans.tag_id')
                ->where('tag_trans.locale', 'ar');
            }, 'result1')
            ->join('tag_trans', 'result1.id', '=', 'tag_trans.tag_id')
            ->select(
                'result1.*',
                'tag_trans.NAME AS enname'
            )
            ->where('tag_trans.locale', 'en')->orderByRaw('created_at DESC')
            ->limit($pageSize) // Set the number of records per page
            ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page

            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    img_tag($row->image,'tags/'),
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
