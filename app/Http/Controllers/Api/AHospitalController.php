<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Hospital;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class AHospitalController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Hospital','route' => 'admin.hospital']);
    }

    public function index(Request $request)
    {
        // if($request->ajax())
        // {
        //     $data = dataTable()
        //         ->of( Hospital::query() )
        //         ->filterColumns(['id', 'slug'])
        //         ->each(function ($row) {
        //             return [
        //                 $row->id,
        //                 img_tag($row->image,'hospitals/'),
        //                 isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
        //                 isset($row->translate('en')->name)?$row->translate('en')->name:'',
        //                 $row->user != null ? $row->user->name  : "",
        //                 date('d-m-Y', strtotime($row->updated_at)),
        //                 table_actions([
        //                     'edit' => ['admin.hospital.edit', ['id' => $row->id]],
        //                     //'copy' => ['admin.hospital.copy', ['id' => $row->id]],
        //                     'delete' => ['admin.hospital.delete', ['id' => $row->id]]
        //                 ])
        //             ];
        //         })
        //         ->rows()
        //     ;

        //     return $data;
        // }

        // $table = app(TableList::class)
        //     ->setModel(Hospital::class)
        //     ->setRequest($request)
        //     // set the route that will be targetted when the create / edit / delete button will be hit.
        //     ->setRoutes([
        //         'index'      => ['alias' => 'admin.hospital.index', 'parameters' => []],
        //     ])
        //     ->addQueryInstructions(function($query) {
        //         $query->select('hospitals.*');
        //         $query->addSelect('hospital_trans.name as name');
        //         $query->join('hospital_trans', 'hospital_id', '=', 'hospitals.id');
        //         $query->where('hospital_trans.locale', '=', 'ar');
        //     });

        // // we add some columns to the table list
        // $table->addColumn('id')
        //     ->isSortable()
        //     ->sortByDefault('desc')
        //     ->isSearchable()
        //     ->useForDestroyConfirmation();
        // $table->addColumn('name')
        //     ->setCustomTable('hospital_trans', 'name')
        //     ->isSortable()
        //     ->isSearchable();
        // $table->addColumn('image')
        //     ->isCustomHtmlElement(
        //         function ($entity, $column) {
        //         return ($entity->{$column->attribute})
        //             ?   img_tag($entity->image,'hospitals/')
        //             : null;
        //     });
        // /*$table->addColumn('id')
        // //   ->isSortable()
        //     ->isSearchable()
        //     //->setCustomTable('hospital_trans', 'name')
        //     ->isCustomValue(function ($entity, $column) {
        //   //  dd($entity->translate('ar')->name );
        //     return ($entity->translate('ar')->name );
        //    });*/
        // $table->addColumn('id')
        //    ->isSearchable()
        //    ->isCustomValue(function ($entity, $column) {
        //        return (date('d-m-Y', strtotime($entity->updated_at)) );
        //    });
        // $table->addColumn('id')
        //       ->isSearchable()
        //       ->isCustomValue(function ($entity, $column) {
        //           return ( $entity->user != null ? $entity->user->name  : "");
        //       });

        // $table->addColumn('id')
        //          ->isSearchable()
        //          ->isCustomHtmlElement(function ($entity, $column) {
        //              //dd($entity->user);
        //              return ( table_actions([
        //         'edit' => ['admin.hospital.edit', ['id' => $entity->id]],
        //         'delete' => ['admin.hospital.delete', ['id' => $entity->id]]
        //     ]) );
        // });
        $hospitals = Hospital::search($request->q)->orderByRaw('created_at DESC')->paginate(10)->fragment('hospitals');

        return response( ['hospitals' => $hospitals], 200);
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

        $item = Hospital::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        $hospitalTypeIds = $item->hospital_types()->pluck('hospital_type_id')->toArray();

        $insuranceCompanies = $item->insuranceCompanies->pluck('name', 'id');
        return response(['item' => $item, 'specialityIds'=> $specialityIds, 'hospitalTypeIds'=> $hospitalTypeIds, 'insuranceCompanies' => $insuranceCompanies], 200);

        // return view($this->getTemplatePath('edit'), ['item' => $item, 'specialityIds'=> $specialityIds, 'hospitalTypeIds'=> $hospitalTypeIds, 'insuranceCompanies' => $insuranceCompanies]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');
        if($request->has('user_id'))
        {
            $postData['user_id'] = $postData['user_id'][0];
        }
        $postData['user_id'] = Auth::id();

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($postData['parent_id'] == 0)
            $postData['parent_id'] = null;

        if($id)
        {
            $row = Hospital::findOrFail($id);
            $row->update($postData);
        }
        else
        {   if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            } else {
                $postData['image'] = '';
            }
            $row = Hospital::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('hospital_types'))
        {
            $row->hospital_types()->sync($postData['hospital_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'hospitals/');
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
            'flash_message' => trans('Saved.success') ,
            'flash_type' => 'success' ,
        ];
      if($request->input('saveNew'))
            return response(['next' => "savenew"]);

        return response(['id' => $row->id], 200);  
        // if($request->input('saveNew'))
        //     return redirect(route('admin.hospital.create'))->with($redirctMsg);

        // return redirect(route('admin.hospital.edit', ['id' => $row->id]))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Hospital::findOrFail($id);
        $row->delete();
        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
        // return redirect(route('admin.hospital.index'))->with([
        //     'flash_message' => trans('admin.delete_success_message') ,
        //     'flash_type' => 'success' ,
        // ]);
    }

    public function copy($id)
    {
        $row = Hospital::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
        // return redirect(route('admin.hospital.index'))->with([
        //     'flash_message' => trans('admin.copy_success_message') ,
        //     'flash_type' => 'success' ,
        // ]);
    }

    public function getTemplateFolder()
    {
        return 'hospital';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('hospitals');
            $hospitals = Hospital::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $hospitals], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $hospitals = Hospital::search($request->q)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('hospitals');
            
            return response(['search_result' => $hospitals], 200);
        }
    }
}
