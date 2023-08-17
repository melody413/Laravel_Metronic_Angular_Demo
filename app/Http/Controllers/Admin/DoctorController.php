<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Doctor;
use App\Models\Qanswer;
use App\Models\Tag;
use App\Models\DoctorBranch;
use Okipa\LaravelBootstrapTableList\TableList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class DoctorController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Doctors','route' => 'admin.doctor']);
    }

    public function index(Request $request)
    {
        $doctors = Doctor::search($request->q)->orderByRaw('created_at DESC')
        ->paginate(15)->fragment('doctors');

        return view($this->getTemplatePath('index'), ['doctors' => $doctors]);
    }

    public function create(Request $request)
    {
        view()->share(['action_title' => 'Create']);

        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Doctor::where('id',$id)->first();

        $specialityIds = $item->specialties()->pluck('specialty_id')->toArray();

        $hospitals = $item->hospitals()->listsTranslations('name')->pluck('name','id')->toArray();
        $centers = $item->centers()->listsTranslations('name')->pluck('name','id')->toArray();

        $insuranceCompanies = $item->insuranceCompanies()->listsTranslations('name')->pluck('name','id')->toArray();

        $branch = DoctorBranch::where('doctor_id', $id)->first();
        $tags = Tag::where('module_name', 'doctor')->get();
        //dd($item->description);
        $tags_ar=''; $tags_en='';
        
        return view($this->getTemplatePath('edit'), ['item' => $item, 'branch'=>$branch,
        'specialityIds' => $specialityIds, 'hospitals'=> $hospitals, 'insuranceCompanies'=> $insuranceCompanies, 
        'tags'=> $tags, 'centers' => $centers]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        if($request->has('user_id'))
        {
            $postData['user_id'] = $postData['user_id'][0];
        }
        $postData['user_entry_id'] = Auth::id();

        $request->validate([
            'ar.name' => 'required|max:255',
            'ar.title' => 'required|max:255',
            'ar.address' => 'required|max:255',
            'en.address' => 'required|max:255',
            'en.name' => 'required|max:255',
            'en.title' => 'required|max:255',
            'phone' => 'required',
            'specialties' => 'required',
            //'image' => 'required',
            //'slug' => 'required|max:255|unique:doctors,id,' . $id,
        ]);

        if($id)
        {
            $row = Doctor::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Doctor::create($postData);
        }

        $postData['doctor_id'] = $row->id;
        //get first branch id
        $branch = DoctorBranch::where('doctor_id', $row->id)->first();
        $this->saveBrnachInCreate($request, $postData, isset($branch->id)?$branch->id:null);


        if($request->hasFile('image'))
        {
            $image = $this->moveFile($request->file('image') , 'doctors/');
            $row->image = $image;
            $row->save();
        }

        if($request->has('image_delete'))
        {
            $row->image = '';
            $row->save();
        }

        if($request->has('image_gallery'))
        {
            $row->image_gallery = json_encode($postData['image_gallery']);
            $row->save();
        }

        if ($postData['image_gallery_count'] == 0)
        {
            $row->image_gallery = '';
            $row->save();
        }

        if($request->has('specialties'))
        {
            $row->specialties()->sync($postData['specialties']);
        }

        if($request->has('hospital_ids'))
        {
            $row->hospitals()->sync($postData['hospital_ids']);
        } else {
            $row->hospitals()->sync([]);
        }

        if($request->has('center_ids'))
        {
            $row->centers()->sync($postData['center_ids']);
        } else {
            $row->centers()->sync([]);
        }

        if($request->has('insurance_company_ids'))
        {
            $row->insuranceCompanies()->sync($postData['insurance_company_ids']);
        } else {
            $row->insuranceCompanies()->sync([]);
        }

        //dd($request->input('is_active'));
        if( ! $request->input('is_reserve'))
        {
            $row->is_reserve = 0;
            $row->save();
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        if($request->input('saveNew'))
            return redirect(route('admin.doctor.create'))->with($redirctMsg);

        return redirect(route('admin.doctor.edit', ['id' => $row->id]))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Doctor::findOrFail($id);
        $row->delete();

        return redirect(route('admin.doctor.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function saveBrnachInCreate($request, $postData, $id = null)
    {
        $workDay = '';
        $odr = [1,1,1,1,1,1,1];

        //dd($postData['work_days']);

        foreach ($odr as $k=>$d)
        {
            if(isset($postData['work_days'][$k]) && $postData['work_days'][$k] == 1)
                $workDay .= '1';
            else
                $workDay .= '0';
        }

        $postData['day_of_week'] = $workDay;

        if($id)
        {
            $row = DoctorBranch::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = DoctorBranch::create($postData);
        }

    }

    public function copy($id)
    {
        $row = Doctor::findOrFail($id);

        $row->slug = $row->slug . '-copy';

        $new = $row->replicateWithTranslations();
        $new->save();

        return redirect(route('admin.doctor.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'doctor';
    }
}
