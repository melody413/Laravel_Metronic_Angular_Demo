<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Qanswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QanswerController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Qanswer','route' => 'admin.qanswer']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = dataTable()
                ->of( Qanswer::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    return [
                        $row->id,
                        img_tag($row->image,'qanswers/'),
                        isset($row->translate('ar')->name)?$row->translate('ar')->name:'',
                        isset($row->translate('en')->name)?$row->translate('en')->name:'',
                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.qanswer.edit', ['id' => $row->id]],
                            //'copy' => ['admin.qanswer.copy', ['id' => $row->id]],
                            'delete' => ['admin.qanswer.delete', ['id' => $row->id]]
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

        $item = Qanswer::findOrFail($id);
        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();
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
            $row = Qanswer::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Qanswer::create($postData);
        }
// dd($request->all());
        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('medicine_categories'))
        {
            $row->medicine_categories()->sync($postData['medicine_categories']);
        }

        if($request->has('qanswer_types'))
        {
            $row->qanswer_types()->sync($postData['qanswer_types']);
        }

        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'qanswers/');
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
            return redirect(route('admin.qanswer.create'))->with($redirctMsg);

        return redirect(route('admin.qanswer.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Qanswer::findOrFail($id);
        $row->delete();

        return redirect(route('admin.qanswer.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = Qanswer::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.qanswer.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'qanswer';
    }
}
