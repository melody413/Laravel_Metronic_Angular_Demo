<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class APageController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Pages','route' => 'admin.page']);
    }

    public function index(Request $request)
    {
   
        $data = dataTable()
            ->of( Page::query() )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    img_tag($row->image,'pages/'),
                    isset($row->translate('ar')->title)?$row->translate('ar')->title:'',
                    $row->slug,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.page.edit', ['id' => $row->id]],
                        //'copy' => ['admin.page.copy', ['id' => $row->id]],
                        'delete' => ['admin.page.delete', ['id' => $row->id]]
                    ])
                ];
            })
            ->rows();
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
        $item = Page::findOrFail($id);
        return response(['item' => $item], 200);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.title' => 'required|max:255',
            'en.title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages,id,' . $id,
        ]);

        if($id)
        {
            $row = Page::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Page::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'pages/');
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
        $row = Page::findOrFail($id);
        $row->delete();

        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = Page::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();
        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'page';
    }
}
