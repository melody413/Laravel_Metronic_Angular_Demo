<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TagController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Tag','route' => 'admin.tag']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = dataTable()
                ->of( Tag::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    return [
                        $row->id,
                        img_tag($row->image,'tags/'),
                        isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                        isset($row->translate('en')->name)?$row->translate('en')->name:'',
                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.tag.edit', ['id' => $row->id]],
                            //'copy' => ['admin.tag.copy', ['id' => $row->id]],
                            'delete' => ['admin.tag.delete', ['id' => $row->id]]
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

        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Tag::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
        //$tagTypeIds = $item->tag_types()->pluck('tag_type_id')->toArray();
        $categoryIds = $item->medicine_categories()->pluck('medicines_category_id')->toArray();
        return view($this->getTemplatePath('edit'), ['item' => $item, 'specialityIds'=> $specialityIds, 'categoryIds'=> $categoryIds]);
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
            $row = Tag::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Tag::create($postData);
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('medicine_categories'))
        {
            $row->medicine_categories()->sync($postData['medicine_categories']);
        }

        if($request->has('tag_types'))
        {
            $row->tag_types()->sync($postData['tag_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'tags/');
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
            return redirect(route('admin.tag.create'))->with($redirctMsg);

        return redirect(route('admin.tag.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Tag::findOrFail($id);
        $row->delete();

        return redirect(route('admin.tag.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = Tag::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.tag.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'tag';
    }
}
