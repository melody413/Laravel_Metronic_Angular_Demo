<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\BodyPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BodyPartController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'BodyPart','route' => 'admin.body_part']);
    }

    public function index(Request $request)
    {

        if($request->ajax())
        {
            $data = dataTable()
                ->of( BodyPart::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    $parent = "";
                    if ($row->parent)
                        $parent = BodyPart::find($row->parent)->name;

                    return [
                        $row->id,
                        img_tag($row->image,'body_parts/'),
                        isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                        $parent,
                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.body_part.edit', ['id' => $row->id]],
                            //'copy' => ['admin.body_part.copy', ['id' => $row->id]],
                            'delete' => ['admin.body_part.delete', ['id' => $row->id]]
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
        $body_parts = BodyPart::all();

        return view($this->getTemplatePath('create'),['body_parts' => $body_parts]);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = BodyPart::findOrFail($id);
        // $body_partTypeIds = $item->body_part_types()->pluck('body_part_type_id')->toArray();
        $body_parts = BodyPart::all();
        // $body_parts_parent = [];
        // if($item->parent)
        //     $body_parts_parent = array_map('intval', json_decode($item->parent, true));
        $body_parts_parent = (explode(",",$item->parent));

        // dd($body_parts_parent);
        return view($this->getTemplatePath('edit'), ['item' => $item,
        'body_parts' => $body_parts, 'body_parts_parent' => $body_parts_parent]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        if($request->parent)
            $postData['parent'] = (implode(",", $request->parent));
            // dd($request->parent);

        $request->validate([
            'ar.name' => 'required|max:255',
            'en.name' => 'required|max:255'
        ]);

        if($id)
        {
            $row = BodyPart::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = BodyPart::create($postData);
        }
        
        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'body_parts/');
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
            return redirect(route('admin.body_part.create'))->with($redirctMsg);

        return redirect(route('admin.body_part.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = BodyPart::findOrFail($id);
        $row->delete();

        return redirect(route('admin.body_part.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = BodyPart::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.body_part.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'body_part';
    }
}
