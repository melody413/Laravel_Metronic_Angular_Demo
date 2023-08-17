<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Tag;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class TagController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.sub_category.index'),
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
            ->of( Tag::query() )
            ->filterWithArea()
            ->filterWithCity()
            ->filterWithInsuranceCompany()
            ->filterWithName()
            ->paginate()
        ;

        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();

        $page_title = getMainModuleTitle('sub_categorys',$city, $area);

        return view($this->getTemplatePath('index'), compact('rows', 'area', 'city', 'page_title'));
    }

    public function unit($id)
    {
        $row = Tag::where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
                new \Exception('Tag not found')
            );
        }
        $page_title = trans('general.sub_category') . ' ' . $row->name;

        view()->share(['sub_category' => $row, 'page_title' => $page_title]);
        breadcrumb([
            'Home' => route('frontend.home'),
            'Tag' => route('frontend.sub_category.index'),
            $row->name => '',
        ]);

        return view($this->getTemplatePath('unit'), compact(['row']));
    }

    protected function getTemplateFolder()
    {
        return 'sub_category';
    }
}
