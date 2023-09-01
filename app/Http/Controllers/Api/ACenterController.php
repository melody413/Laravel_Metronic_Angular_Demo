<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class ACenterController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Center','route' => 'admin.center']);
    }

    public function index(Request $request)
    {
        // if($request->ajax())
        // {
        //     $data = dataTable()
        //         ->of( Center::query() )
        //         ->filterColumns(['id', 'slug'])
        //         ->each(function ($row) {
        //             return [
        //                 $row->id,
        //                 img_tag($row->image,'centers/'),
        //                 isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
        //                 isset($row->translate('en')->name)?$row->translate('en')->name:'',
        //                 date('d-m-Y', strtotime($row->updated_at)),
        //                 table_actions([
        //                     'edit' => ['admin.center.edit', ['id' => $row->id]],
        //                     //'copy' => ['admin.center.copy', ['id' => $row->id]],
        //                     'delete' => ['admin.center.delete', ['id' => $row->id]]
        //                 ])
        //             ];
        //         })
        //         ->rows()
        //     ;

        //     return $data;
        // }
        $centers = Center::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('centers');

        return response(["centers" => $centers], 200);
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        return response(['action_title' => 'Create'], 200);

        // return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Center::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        //$centerTypeIds = $item->center_types()->pluck('center_type_id')->toArray();

        $insuranceCompanies = $item->insuranceCompanies->pluck('name', 'id');
        return response(['item' => $item, 'specialityIds'=> $specialityIds/*, 'centerTypeIds'=> $centerTypeIds*/, 'insuranceCompanies' => $insuranceCompanies], 200);

        // return view($this->getTemplatePath('edit'), ['item' => $item, 'specialityIds'=> $specialityIds/*, 'centerTypeIds'=> $centerTypeIds*/, 'insuranceCompanies' => $insuranceCompanies]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
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
            $row = Center::findOrFail($id);
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
            $row = Center::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('center_types'))
        {
            $row->center_types()->sync($postData['center_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'centers/');
            $row->image = $image;
            $row->save();
        }

        if($request->has('image_delete'))
        {
            $row->image = '';
            $row->save();
        }

        if($request->has('image_gallery'))
        {
            $row->image_gallery = json_encode($postData['image_gallery']);
            $row->save();
        }

        if ($postData['image_gallery_count'] == 0)
        {
            $row->image_gallery = '';
            $row->save();
        }

        if($request->has('insurance_company_ids'))
        {
            $row->insuranceCompanies()->sync($postData['insurance_company_ids']);
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
        $row = Center::findOrFail($id);
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = Center::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'center';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('centers');
            $centers = Center::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $centers], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $centers = Center::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('centers');
            
            return response(['search_result' => $centers], 200);
        }
    }
}
