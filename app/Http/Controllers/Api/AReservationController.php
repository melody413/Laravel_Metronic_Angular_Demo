<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Admin\BaseController;
use App\Models\Doctor;
use App\Models\DoctorReservation as Reservation;
use Illuminate\Http\Request;



class AReservationController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Reservation', 'route' => 'admin.reservation']);
    }

    public function index($id = null, Request $request)
    {
        $id = $request->get('id');

        view()->share(['module_title' => 'reservation']);

        #->where('doctor_id', $id
        $data = dataTable()
            ->of( Reservation::query() )
            ->where('doctor_id', $id)
            ->filterColumns(['id', 'slug'])
            ->heads([
                ['label'=> '#ID', 'attr'=> ['orderable'=> 1]],
                ['label'=> '#ID'],
                ['label'=> 'Date'],
            ])
            ->each(function ($row) {
                $shortcut = json_decode($row->shortcut, true);
                return [
                    $row->id,
                     '#'.$row->doctor_id.' <a href="'.route('admin.doctor.edit', ['id' => $row->doctor_id]).'">'. $shortcut['doctor_name'] .'</a>',
                     $row->name . '<br>'.
                     '<a href="mailto:'.$row->email.'">'.$row->email.'</a><br>'.
                     '<a href="tel:'.$row->phone.'">'.$row->phone.'</a><br>',
                     $row->reserve_date .' <strong>'. $row->reserve_time .'</strong>',
                     $shortcut['country_name'] . ' ' . $shortcut['city_name'] . ' ' . $shortcut['area_name'] . '<br>' .
                     '<a href="'.route('admin.doctor_branch.edit', ['id' => $row->doctor_branch_id]).'">'.$shortcut['reservation_address_ar'].'</a><br>',
                     date('d-m-Y', strtotime($row->created_at)),
                ];
            })
            ->actions(function($row){
                return [
                    #'view' => ['admin.reservation.view', ['id' => $row->id]],
                    'delete' => ['admin.reservation.delete', ['id' => $row->id]],
                    //'toggle_active' => ['admin.reservation.toggle_active', ['id' => $row->id]]
                ];
            })
            ->rows()
        ;
        
        return response(['data' => $data], 200);
    }

    public function view($id)
    {
        $item = Reservation::findOrFail($id);

        return view($this->getTemplatePath('index'), compact(['id']));
    }

    public function create($id)
    {
        $doctor = Doctor::findOrFail($id);

        view()->share(['action_title' => 'Add New']);

        return view($this->getTemplatePath('create'), ['doctor' => $doctor]);
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Reservation::findOrFail($id);

        return view($this->getTemplatePath('edit'), ['item' => $item]);
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
            $row = Reservation::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Reservation::create($postData);
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        if($request->input('saveNew'))
            return redirect(route('admin.reservation.index', ['id' => $row->doctor_id]))->with($redirctMsg);

        return redirect(route('admin.reservation.index', ['id' => $row->doctor_id]))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Reservation::findOrFail($id);
        $doctorId = $row->doctor_id;
        $row->delete();

        return redirect(route('admin.reservation.index', ['id' => $doctorId]))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function getTemplateFolder()
    {
        return 'reservation';
    }

}
