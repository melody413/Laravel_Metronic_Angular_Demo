<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;

class AFaqController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Faqs','route' => 'admin.faq']);
    }

    public function index(Request $request)
    {
        
        $data = dataTable()
            ->of( Faq::query()->orderByRaw('created_at DESC') )
            ->filterColumns(['id', 'slug'])
            ->each(function ($row) {
                return [
                    $row->id,
                    img_tag($row->image,'faqs/'),
                    isset($row->translate('ar')->title)?$row->translate('ar')->title:'',
                    $row->slug,
                    date('d-m-Y', strtotime($row->updated_at)),
                    table_actions([
                        'edit' => ['admin.faq.edit', ['id' => $row->id]],
                        //'copy' => ['admin.faq.copy', ['id' => $row->id]],
                        'delete' => ['admin.faq.delete', ['id' => $row->id]]
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
        $item = Faq::findOrFail($id);
        return response(['item' => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.title' => 'required|max:255',
            'slug' => 'required|max:255|unique:faqs,id,' . $id,
        ]);

        if($id)
        {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            }
            $row = Faq::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $imageName = $file->getClientOriginalName();
                $postData['image'] = $imageName;
            } else {
                $postData['image'] = '';
            }
            $row = Faq::create($postData);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'faqs/');
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

        if($request->input('save_to') == 'save_reload')
            return response(['next' => "save_reload"]);
        else if($request->input('save_to') == 'save_create_new')
            return response(['next' => "savenew"]);
        return response(['id' => $row->id], 200);
    }

    public function delete($id)
    {
        $row = Faq::findOrFail($id);
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function copy($id)
    {
        $row = Faq::findOrFail($id);
        $row->slug = $row->slug . '-copy';
        $new = $row->replicateWithTranslations();
        $new->save();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'faq';
    }
}
