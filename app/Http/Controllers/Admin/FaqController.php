<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FaqController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Faqs','route' => 'admin.faq']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = dataTable()
                ->of( Faq::query() )
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

        $item = Faq::findOrFail($id);

        return view($this->getTemplatePath('edit'), ['item' => $item]);
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
            $row = Faq::findOrFail($id);
            $row->update($postData);
        }
        else
        {
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
            return Redirect::back()->with($redirctMsg);
        else if($request->input('save_to') == 'save_create_new')
            return redirect(route('admin.faq.create'))->with($redirctMsg);

        return redirect(route('admin.faq.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Faq::findOrFail($id);
        $row->delete();

        return redirect(route('admin.faq.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = Faq::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.faq.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'faq';
    }
}
