<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\LabService;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class LabServiceController extends BaseController
{
    public function init(Request $request)
    {
        // $vars = [
        //     'route' => route('frontend.lab_service.index'),
        //     'name'
        // ];

        // $city = $request->input('city',0);
        // if($city)
        // {
        //     $vars['areas'] = dataForm()->getAreas($city);
        // }

        // view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $page_title = 'LabServices';

        $rows = searchManger()
            ->of( LabService::query() )
            ->filterWithName()
            //->filterWithInsuranceCompany()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('lab_service',$city, $area);

        return view($this->getTemplatePath('index'), compact(['rows', 'page_title', 'page_title']));
    }

    public function unit($id)
    {
        $row = LabService::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Row not found')
            );
        }

        $page_title =   trans('general.lab_service') . ' ' .$row->name;
        view()->share(['lab_service' => $row, 'page_title' => $page_title]);

        return view($this->getTemplatePath('unit'), compact(['row','page_title']));
    }

    protected function getTemplateFolder()
    {
        return 'lab_service';
    }
}
