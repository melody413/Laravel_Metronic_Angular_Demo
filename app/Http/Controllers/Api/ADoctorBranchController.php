<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use App\Models\DoctorBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\BaseController;
use App\Models\Specialty;


class ADoctorBranchController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Doctor Rate', 'route' => 'admin.doctor_branch']);
    }

    public function index($id, Request $request)
    {
        $doctor = Doctor::findOrFail($id);

        view()->share(['module_title' => 'Doctor Branches  dr.' . $doctor->name]);

        $data = dataTable()
            ->of( DoctorBranch::query()->where('doctor_id', $id) )
            ->filterColumns(['id', 'slug'])
            ->heads([
                ['label'=> '#ID', 'attr'=> ['orderable'=> 1]],
                ['label'=> 'address Ar'],
                ['label'=> 'phones'],
                ['label'=> 'day of week'],
                ['label'=> 'time start'],
                ['label'=> 'time end'],
                ['label'=> 'Date'],
            ])
            ->each(function ($row) {
                return [
                    $row->id,
                    isset($row->translate('ar')->address)?$row->translate('ar')->address:'',
                    $row->phones,
                    $row->day_of_week,
                    $row->time_start,
                    $row->time_end,
                    $row->price,
                    date('d-m-Y', strtotime($row->updated_at)),
                ];
            })
            ->actions(function($row){
                return [
                    'edit' => ['admin.doctor_branch.edit', ['id' => $row->id]],
                    'delete' => ['admin.doctor_branch.delete', ['id' => $row->id]],
                    //'toggle_active' => ['admin.doctor_branch.toggle_active', ['id' => $row->id]]
                ];
            })
            ->rows();

        return response(["result" => $data], 200);
        // if($request->ajax()  )
        //     return $data;

        // return view($this->getTemplatePath('index'), compact(['id']));
    }

    public function create()
    {
        $specialty = Specialty::all();
        view()->share(['action_title' => 'Add New']);
        return response(['doctor' => $doctor, "specialities"=> $specialty, ], 200);

    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = DoctorBranch::findOrFail($id);
        return response( ['item' => $item], 200);

        // return view($this->getTemplatePath('edit'), ['item' => $item]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'ar.address' => 'required|max:255',
            'en.address' => 'required|max:255',
        ]);

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
        $row = DoctorBranch::findOrFail($id);
        $doctorId = $row->doctor_id;
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function toggleActive($id, Request $request)
    {
        $row = DoctorBranch::findOrFail($id);
        $row->is_active = $row->is_active != 1?1:0;
        $row->save();


        return reponse(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function getTemplateFolder()
    {
        return 'doctor_branch';
    }

}
