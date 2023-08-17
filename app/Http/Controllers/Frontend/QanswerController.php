<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Qanswer;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class QanswerController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.qanswer.index'),
            'city',
            'area',
            'insurance',
            'name'
        ];

        $city = $request->input('city',0);
        if($city)
        {
            $vars['areas'] = dataForm()->getAreas($city);
        }

        view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $rows = searchManger()
            ->of( Qanswer::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithInsuranceCompany()
            ->filterWithName()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('qanswers',$city, $area);

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function unit($id)
    {
        $row = Qanswer::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Qanswer not found')
            );
        }
        $page_title = trans('general.qanswer') . ' ' . $row->name;

        view()->share(['qanswer' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'Qanswer' => route('frontend.qanswer.index'),
            $row->name => '',
        ]);

        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'qanswer';
    }
}
