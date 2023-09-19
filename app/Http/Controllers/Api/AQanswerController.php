<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Mangers\DataTableManger;
use App\Mangers\DataForm;
use App\Models\Qanswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use App\Models\MedicinesCategoryTrans;

class AQanswerController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Qanswer','route' => 'admin.qanswer']);
    }

    public function index(Request $request)
    {
        $data = dataTable()
            ->of( Qanswer::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    img_tag($row->image,'qanswers/'),
                    isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                    isset($row->translate('en')->name)?$row->translate('en')->name:'',
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.qanswer.edit', ['id' => $row->id]],
                        //'copy' => ['admin.qanswer.copy', ['id' => $row->id]],
                        'delete' => ['admin.qanswer.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows()
        ;
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

        $item = Qanswer::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
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
            $row = Qanswer::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Qanswer::create($postData);
        }
// dd($request->all());
        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('medicine_categories'))
        {
            $row->medicine_categories()->sync($postData['medicine_categories']);
        }

        if($request->has('qanswer_types'))
        {
            $row->qanswer_types()->sync($postData['qanswer_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'qanswers/');
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
        $row = Qanswer::findOrFail($id);
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = Qanswer::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.copy_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'qanswer';
    }

    public function getSpeciality(){
        $speciallities = DataForm::getSpeciality();
        return response(["specialities" => $speciallities], 200);
    }

    public function getCategory(){
        $category = MedicinesCategoryTrans::where('locale','ar')->get();
        return response(["categories" => $category]);
    }   

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table(function ($query) use ($searchIndex) {
                $query->select(
                        'qanswers.*',
                        'qanswer_trans.NAME AS arname'
                    )
                    ->from('qanswers')
                    ->join('qanswer_trans', 'qanswers.id', '=', 'qanswer_trans.qanswer_id')
                    ->where('qanswer_trans.locale', 'ar');
            }, 'result1')
            ->join('qanswer_trans', 'result1.id', '=', 'qanswer_trans.qanswer_id')
            ->select(
                'result1.*',
                'qanswer_trans.NAME AS enname'
            )
            ->where('qanswer_trans.locale', 'en')
            ->orderByRaw('created_at DESC');
            
            $results = $query->where(function($query) use ($searchIndex) {
                $query->where('result1.arname', 'LIKE', "%$searchIndex%")
                      ->orWhere('qanswer_trans.NAME', 'LIKE', "%$searchIndex%");
            })->get();
            
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    img_tag($row->image,'qanswers/'),
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
                        'qanswers.*',
                        'qanswer_trans.NAME AS arname'
                    )
                    ->from('qanswers')
                    ->join('qanswer_trans', 'qanswers.id', '=', 'qanswer_trans.qanswer_id')
                    ->where('qanswer_trans.locale', 'ar');
            }, 'result1')
            ->join('qanswer_trans', 'result1.id', '=', 'qanswer_trans.qanswer_id')
            ->select(
                'result1.*',
                'qanswer_trans.NAME AS enname'
            )
            ->where('qanswer_trans.locale', 'en')
            ->orderByRaw('created_at DESC')
            ->limit($pageSize) // Set the number of records per page
            ->offset(($pageIndex - 1) * $pageSize); // Calculate the offset based on the desired page

            $results = $query->get(); 
            $resultsArray = $results->toArray();
            $transformedResults = array_map(function ($row) {
                return [                
                    $row->id,
                    img_tag($row->image,'qanswers/'),
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
