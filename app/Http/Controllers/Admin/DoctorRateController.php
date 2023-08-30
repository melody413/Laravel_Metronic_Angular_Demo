<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use App\Models\DoctorRating;
use Illuminate\Http\Request;


class DoctorRateController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Doctor Rate', 'route' => 'admin.doctor_rate']);
    }

    public function index($id, Request $request)
    {
        $doctor = Doctor::findOrFail($id);

        view()->share(['module_title' => 'Doctor Rate  dr.' . $doctor->name]);

        //dd(DoctorRating::query()->where('doctor_id', $id)->get());

        $data = dataTable()
            ->of( DoctorRating::query()->where('doctor_id', $id) )
            ->filterColumns(['id', 'slug'])
            ->heads([
                ['label'=> '#ID', 'attr'=> ['orderable'=> 1]],
                ['label'=> 'User name'],
                ['label'=> 'rate'],
                ['label'=> 'comment'],
                ['label'=> 'Date'],
            ])
            ->each(function ($row) {
                return [
                    $row->id,
                    $row->user->name,
                    $row->rate,
                    $row->comment,
                    date('d-m-Y', strtotime($row->updated_at)),

                ];
            })
            ->actions(function($row){
                return [
                    'delete' => ['admin.doctor_rate.delete', ['id' => $row->id]],
                    'toggle_active' => ['admin.doctor_rate.toggle_active', ['id' => $row->id]]
                ];
            })
            ->rows()
        ;

        if($request->ajax()  )
            return $data;

        return view($this->getTemplatePath('index'), compact(['id']));
    }

    public function toggleActive($id, Request $request)
    {
        $row = DoctorRating::findOrFail($id);
        $row->is_active = $row->is_active != 1?1:0;
        $row->save();

        return redirect(route('admin.doctor_rate.index', ['id' => $row->doctor_id ]))->with([
            'flash_message' => trans('admin.save.success') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'doctor_rate';
    }

}
