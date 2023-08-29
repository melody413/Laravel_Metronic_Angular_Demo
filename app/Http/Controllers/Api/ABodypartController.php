<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Admin\BaseController;
use App\Mangers\DataTableManger;
use App\Models\BodyPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ABodyPartController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'BodyPart','route' => 'admin.body_part']);
    }

    public function index(Request $request)
    {

        $data = dataTable()
            ->of( BodyPart::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                $parent = "";
                if ($row->parent)
                    $parent = BodyPart::find($row->parent)->name;

                return [
                    $row->id,
                    img_tag($row->image,'body_parts/'),
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    $parent,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.body_part.edit', ['id' => $row->id]],
                        'delete' => ['admin.body_part.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();
        return response($data);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $body_parts = BodyPart::all();
        return response(['body_parts' => $body_parts], 200);
        // return view($this->getTemplatePath('create'),['body_parts' => $body_parts]);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = BodyPart::findOrFail($id);
        // $body_partTypeIds = $item->body_part_types()->pluck('body_part_type_id')->toArray();
        $body_parts = BodyPart::all();
        // $body_parts_parent = [];
        // if($item->parent)
        //     $body_parts_parent = array_map('intval', json_decode($item->parent, true));
        $body_parts_parent = (explode(",",$item->parent));
        // dd($body_parts_parent);
        return response(['item' => $item,
        'body_parts' => $body_parts, 'body_parts_parent' => $body_parts_parent], 200);
    }

    /**
     *  module_name: string
     *  ar[name]: string
     *  ar[excerpt]: string
     *  ar[description]: string
     *  en[name]: string
     *  en[excerpt]: string
     *  en[description]: string
     *  country_id: number
     *  parent[]: number
     *  image: file
     *  is_active: boolean
     */
    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        if($request->parent)
            $postData['parent'] = (implode(",", $request->parent));

        if($postData['country_id'] == null) $postData['country_id'] = 1;

        if($postData['ar']['name'] == null || $postData['en']['name'] == null){
            return response(['fail' => "input name correctly"], 400);
        }


        if($id)
        {
            $row = BodyPart::findOrFail($id);
            $row->update($postData);
            return response(["result" => "update success"], 200);
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
            $row = BodyPart::create($postData);
        }
        if($request->hasFile('image'))
        {            
            $image = $this->moveFile($request->file('image') , 'body_parts/');
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
        return response(["result"=> $redirctMsg], 200);

    }

    public function delete($id)
    {
        $row = BodyPart::findOrFail($id);
        $row->delete();
        return response([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ], 200);
    }

    public function copy($id)
    {
        $row = BodyPart::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success' ,], 200);
    }

    public function getTemplateFolder()
    {
        return 'body_part';
    }
    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('body_parts');
            $query->select('body_parts.*');
            $query->addSelect('body_part_trans.name as name');
            $query->join('body_part_trans', 'body_part_id', '=', 'body_parts.id');
            $query->where('body_part_trans.locale', '=', 'ar');
            $results = $query->where('name', 'LIKE', "%$searchIndex%")->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                $parent = "";
                if ($row->parent)
                    $parent = BodyPart::find($row->parent)->name;
            
                return [
                    $row->id,
                    img_tag($row->image, 'body_parts/'),
                    // isset($row->translate('ar')->name) ? $row->translate('ar')->name : '',
                    $row->name,
                    $parent,
                    date('d-m-Y', strtotime($row->updated_at)),
                    [
                        'edit' => ['admin.body_part.edit', ['id' => $row->id]],
                        'delete' => ['admin.body_part.delete', ['id' => $row->id]]
                    ]
                ];
            }, $resultsArray);
            
            return response(["search_result" => $transformedResults], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;

            $query = DB::table('body_parts')
                ->select('body_parts.*', 'body_part_trans.name as name')
                ->join('body_part_trans', 'body_part_id', '=', 'body_parts.id')
                ->where('body_part_trans.locale', '=', 'ar')
                ->limit($pageSize) // Set the number of records per page
                ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page

            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                $parent = "";
                if ($row->parent)
                    $parent = BodyPart::find($row->parent)->name;
            
                return [
                    $row->id,
                    img_tag($row->image, 'body_parts/'),
                    // isset($row->translate('ar')->name) ? $row->translate('ar')->name : '',
                    $row->name,
                    $parent,
                    date('d-m-Y', strtotime($row->updated_at)),
                    [
                        'edit' => ['admin.body_part.edit', ['id' => $row->id]],
                        'delete' => ['admin.body_part.delete', ['id' => $row->id]]
                    ]
                ];
            }, $resultsArray);
            return response(["search_result" => $transformedResults], 200);
            
        }
    }
}
