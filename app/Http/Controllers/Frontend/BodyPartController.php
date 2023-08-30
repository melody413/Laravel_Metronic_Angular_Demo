<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Country;
use App\Models\BodyPart;
use App\Models\Disease;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class BodyPartController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.body_part.index'),
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
            ->of( BodyPart::query() )
            ->filterWithName()
            ->paginate()
        ;
// dd($rows);
        $page_title = getMainModuleTitle('body_parts',"", "");
        // dd($parent);
        return view($this->getTemplatePath('index'), compact('rows', 'page_title'));
    }


    public function unit($id)
    {
        $row = BodyPart::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('BodyPart not found')
            );
        }
// $diseases_arr = [];
        $page_title = trans('general.body_part') . ' ' . $row->name;
        $diseases = Disease::where("body_part_ids", "like" , '%"' .$id. '"%')->get();
        // if($diseases)
        //     $diseases_arr = array_map('intval', json_decode($diseases, true));

        view()->share(['body_part' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'BodyPart' => route('frontend.body_part.index'),
            $row->name => '',
        ]);
        return view($this->getTemplatePath('unit'), compact(['row','diseases']));
    }

    protected function getTemplateFolder()
    {
        return 'body_part';
    }
}
