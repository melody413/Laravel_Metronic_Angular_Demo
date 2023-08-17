<?php

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\AppointmentDateTime;
use App\Model\Patient;
use App\Model\PatientAppointment;
use App\Model\PatientPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse
     * Redirect to /new-appointment with patient details on session
     */
    public function takePatientToAppointment($patient_id)
    {
        $patient = Patient::select('id','name','phone')->findOrFail($patient_id);
        return redirect()->to('/new-appointment')->with('has_patient',$patient);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new appointment page with all patient and schedule
     */
    public function newAppointment()
    {
        $schedule = Appointment::where('user_id', auth()->user()->id)->get();
        $patients = Patient::where('user_id', auth()->user()->id)->select('id','name','phone')->orderBy('name','asc')->get();
        return view('user.doctor.appointment.new',[
            'patients'      =>      $patients,
            'schedules'     =>      $schedule
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show all appointment page
     */
    public function allAppointment()
    {
        return view('user.doctor.appointment.all');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show today's appointment page
     */
    public function appointmentToday()
    {
        return view('user.doctor.appointment.today.appointment-today');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Get patient appointment by appointment id
     * Show edit appointment page with all schedule, patients and patient appointment
     */
    public function editAppointment($id)
    {
        $appointment = PatientAppointment::findOrFail($id);
        $schedule = Appointment::where('user_id', auth()->user()->id)->get();
        $patients = Patient::where('user_id', auth()->user()->id)->select('id','name','phone')->orderBy('name','asc')->get();
        return view('user.doctor.appointment.edit',[
            'patients'      =>      $patients,
            'schedules'     =>      $schedule,
            'appointment'   =>      $appointment
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete and appointment
     */
    public function deleteAppointment($id)
    {
        $patient_appointment = PatientAppointment::findOrFail($id);
        if($patient_appointment->payment){
            PatientPayment::where('patient_appointment_id',$id)->delete();
        }
        if(PatientAppointment::destroy($id)){
            return redirect()->back()->with('delete_appointment','Appointment deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save appointment
     */
    public function saveAppointment(Request $request)
    {
        $request->validate([
            'patient_id'    =>  'required',
            'appointment_id'    =>  'required',
            'date'    =>  'required|date',
        ]);

        if($this->appointmentDateValidate($request)){
            $appointment = new PatientAppointment();
            $appointment->patient_id = $request->get('patient_id');
            $appointment->date = Carbon::parse($request->get('date'))->format('Y-m-d');
            $appointment->time = $request->get('time');
            $appointment->appointment_id = $request->get('appointment_id');
            $appointment->note = $request->get('note');
            $appointment->user_id =auth()->user()->id;
            if($appointment->save()){
                if($request->get('payment') != null || $request->get('payment') != ''){
                    $payment = new PatientPayment();
                    if($this->savePayment($payment,$request,$appointment->id)){
                        return response()->json(['Appointment Saved Successfully','Appointment has been saved successfully'],200);
                    }
                }
                return response()->json(['Appointment Saved Successfully','Appointment has been saved successfully'],200);
            }
        }else{
            return response()->json(['Doctor will not coming on this day on this spot'], 422);
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update an appointment
     */
    public function updateAppointment(Request $request,$id)
    {
        $request->validate([
            'patient_id'    =>  'required',
            'appointment_id'    =>  'required',
            'date'    =>  'required|date',
        ]);
        if($this->appointmentDateValidate($request)){
            $appointment = PatientAppointment::findOrFail($id);
            $appointment->patient_id = $request->get('patient_id');
            $appointment->date = Carbon::parse($request->get('date'))->format('Y-m-d');
            $appointment->time = $request->get('time');
            $appointment->appointment_id = $request->get('appointment_id');
            $appointment->note = $request->get('note');
            $appointment->user_id =auth()->user()->id;
            if($appointment->save()){
                if($request->get('payment') != null || $request->get('payment') != ''){
                    if($appointment->payment){
                        $payment = new PatientPayment();
                        $this->savePayment($payment,$request,$appointment->id);
                    }else{
                        $payment = PatientPayment::find($appointment->payment->id);
                        $this->savePayment($payment,$request,$appointment->id);
                    }
                }
                return response()->json(['Appointment Saved Successfully','Appointment has been saved successfully'],200);

            }
        }else{
            return response()->json('Doctor will not coming on this day on this spot', 422);
        }

    }


    /**
     * @param $payment
     * @param $request
     * @param $appointment_id
     * @return bool
     * Save payment by appointment id
     */
    private function savePayment($payment,$request,$appointment_id)
    {
        $payment->patient_id = $request->get('patient_id');
        $payment->payment = $request->get('payment');
        $payment->patient_appointment_id = $appointment_id;
        $payment->user_id = auth()->user()->id;
        if($payment->save()){
            return true;
        }
    }

    /**
     * @param $request
     * @return bool|\Illuminate\Http\JsonResponse
     * Check the date of appointment is valid or not
     */
    private function appointmentDateValidate($request)
    {
        $date = Carbon::parse($request->date)->format('D');
        $schedule_days = AppointmentDateTime::where('appointment_id',$request->get('appointment_id'))
            ->where('days','like',$date.'%')
            ->get();
        if(count($schedule_days) == 0) {
            return false;
        }else{
            return true;
        }
    }
}
