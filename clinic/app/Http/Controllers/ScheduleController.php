<?php

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\AppointmentDateTime;
use App\Model\PatientAppointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ScheduleController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new schedule page
     */
    public function newSchedule()
    {
        return view('user.doctor.schedule.new');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * All schedule page
     */
    public function allSchedule()
    {
        return view('user.doctor.schedule.all');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show edit schedule page
     */
    public function editSchedule($id)
    {
        $schedule = Appointment::findOrFail($id);
        return view('user.doctor.schedule.edit',[
            'schedule'      =>      $schedule
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete schedule if not in use in patient appointment
     */
    public function deleteSchedule($id)
    {
        $schedule_in_patient_appointment = PatientAppointment::where('appointment_id',$id)->get();
        if(count($schedule_in_patient_appointment) == 0){
            AppointmentDateTime::where('appointment_id',$id)->delete();
            if(Appointment::destroy($id)){
                return redirect()->back()->with('schedule_delete','Schedule deleted successfully');
            }
        }else{
            return redirect()->back()->with('schedule_delete_fail','Schedule cannot delete');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Get Schedule date and time by schedule id
     * and show view of scheudle date and time
     */
    public function scheduleDateTime($id)
    {
        $schedule = Appointment::findOrFail($id);
        return view('user.doctor.schedule.date-time.new-date-time',[
            'schedule'      =>      $schedule
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save schedule
     */
    public function saveSchedule(Request $request)
    {
        $schedule = new Appointment();
        $schedule->name = $request->get('name');
        $schedule->address = $request->get('address');
        $schedule->phone = $request->get('phone');
        $schedule->email = $request->get('email');
        $schedule->contact_person_name = $request->get('contact_person_name');
        $schedule->user_id = auth()->user()->id;
        if($schedule->save()){
            return response()->json($schedule);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update schedule
     */
    public function updateSchedule(Request $request,$id)
    {
        $schedule = Appointment::findOrFail($id);
        $schedule->name = $request->get('name');
        $schedule->address = $request->get('address');
        $schedule->phone = $request->get('phone');
        $schedule->email = $request->get('email');
        $schedule->contact_person_name = $request->get('contact_person_name');
        $schedule->user_id = auth()->user()->id;
        if($schedule->save()){
            return response()->json($schedule);
        }
    }

    /**
     * @param Request $request
     * @param $schedule_id
     * @return \Illuminate\Http\RedirectResponse
     * Save schedule date and time
     */
    public function saveScheduleDateTime(Request $request,$schedule_id)
    {
        $appointment_datetime = new AppointmentDateTime();
        $appointment_datetime->appointment_id = $schedule_id;
        $appointment_datetime->days = $request->get('days');
        $appointment_datetime->start_time = $request->get('start_time');
        $appointment_datetime->end_time = $request->get('end_time');
        $appointment_datetime->user_id = auth()->user()->id;
        if($appointment_datetime->save()){
            return redirect()->back();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete schedule date time
     */
    public function deleteScheduleDateTime($id)
    {
        if(AppointmentDateTime::destroy($id)){
            return redirect()->back()->with('schedule_date_time_delete','Success');
        }
    }


    /**
     * @param $id
     * @param $start_date
     * @param $end_date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Return schedule report page with report by given value
     */
    public function scheduleReport($id,$start_date,$end_date)
    {
        $request = [
            'id'            =>  $id,
            'start_date'    =>  $start_date,
            'end_date'      =>  $end_date
        ];

        $validator  = Validator::make($request,[
            'id'            =>  'required|numeric',
            'start_date'    =>  'required|date',
            'end_date'      =>  'required|date'
        ]);

        if($validator->fails()){
            return abort(404);
        }

        $schedule = Appointment::select('id','name')->get();
        $query = $id == 0 ? '>' : '=';
        $start_date = Carbon::parse($start_date)->addDay(1)->toDateString();
        $end_date = Carbon::parse($end_date)->addDay(1)->toDateString();
        $patient_appointments = PatientAppointment::where('appointment_id',$query,$id)
            ->whereBetween('created_at',[$start_date,$end_date])
            ->get()
            ->groupBy(function ($data){
                return $data->date->format('M-Y');
            });
        return view('user.doctor.schedule.report',[
            'schedules'                 =>  $schedule,
            'patient_appointments'      =>  $patient_appointments,
            'schedule_id'               =>  $id,
            'start'                     =>  $start_date,
            'end'                       =>  $end_date
        ]);

    }
}
