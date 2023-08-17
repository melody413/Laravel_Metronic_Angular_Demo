<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SubCategoryController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'SubCategory','route' => 'admin.sub_category']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = dataTable()
                ->of( SubCategory::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    return [
                        $row->id,
                        img_tag($row->image,'sub_categories/'),
                        isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                        isset($row->translate('en')->name)?$row->translate('en')->name:'',
                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.sub_category.edit', ['id' => $row->id]],
                            //'copy' => ['admin.sub_category.copy', ['id' => $row->id]],
                            'delete' => ['admin.sub_category.delete', ['id' => $row->id]]
                        ])
                    ];
                })
                ->rows()
            ;

            return $data;
        }

        return view($this->getTemplatePath('index'));
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        $sub_categories = SubCategory::all();

        return view($this->getTemplatePath('create'),['sub_categories' => $sub_categories]);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = SubCategory::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        // $sub_categoryTypeIds = $item->sub_category_types()->pluck('sub_category_type_id')->toArray();
        $sub_categories = SubCategory::all();
        $sub_categories_parent = [];
        if($item->parent)
            $sub_categories_parent = array_map('intval', json_decode($item->parent, true));

        // dd($sub_categories_parent);
        return view($this->getTemplatePath('edit'), ['item' => $item, 'specialityIds'=> $specialityIds,
        'sub_categories' => $sub_categories, 'sub_categories_parent' => $sub_categories_parent]);
    }

    public function store(Request $request)
    {
        if($request->parent)
            $request->parent = (implode(",", $request->parent));

        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = SubCategory::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = SubCategory::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('sub_category_types'))
        {
            $row->sub_category_types()->sync($postData['sub_category_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'sub_categories/');
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
            return redirect(route('admin.sub_category.create'))->with($redirctMsg);

        return redirect(route('admin.sub_category.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = SubCategory::findOrFail($id);
        $row->delete();

        return redirect(route('admin.sub_category.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = SubCategory::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.sub_category.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'sub_category';
    }
}
