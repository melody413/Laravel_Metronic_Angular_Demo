<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Country;
use App\Models\Disease;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class DiseaseController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.disease.index'),
            'parent',
            'name'
        ];

        // $city = $request->input('city',0);
        // if($city)
        // {
        //     $vars['areas'] = dataForm()->getAreas($city);
        // }

        view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $rows = searchManger()
            ->of( Disease::query() )
            ->filterWithName()
            ->paginate()
        ;

        $page_title = getMainModuleTitle('diseases',"", "");
        // dd($parent);
        return view($this->getTemplatePath('index'), compact('rows', 'page_title'));
    }


    public function unit($id)
    {
        $row = Disease::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Disease not found')
            );
        }

        $page_title = trans('general.disease') . ' ' . $row->name;
//         $diseases = Disease::where("disease_ids", "like" , '%"' .$id. '"%');
// dd($diseases);
        view()->share(['disease' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'Disease' => route('frontend.disease.index'),
            $row->name => '',
        ]);
        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'disease';
    }
}
