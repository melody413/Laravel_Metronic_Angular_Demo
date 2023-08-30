<?php

namespace App\Http\Controllers;

use App\Model\Drug;
use App\Model\Patient;
use App\Model\PatientAppointment;
use App\Model\PrescriptionTemplate;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;

use App\Model\Prescription;
use App\Model\PrescriptionLeft;
use App\Model\PrescriptionDrug;

class PrescriptionController extends Controller
{
    /**
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse
     * Redirect to /new-prescription with patient data in session
     */
    public function takePatientToPrescription($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        return redirect()->to('/new-prescription')
            ->with('has_patient',$patient);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * SHow print prescription page
     */
    public function printPrescription($id)
    {
        $prescription = Prescription::findOrFail($id);
        return view('user.doctor.prescription.print',[
            'prescription'  =>  $prescription
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new prescription page with drugs,template and patient
     */
    public function newPrescription()
    {
        $drugs = Drug::select('id','name')->where('status',1)->orderBy('name','asc')->get();
        $template = PrescriptionTemplate::where('user_id', auth()->user()->id)->select('id','name')->where('status',1)->orderBy('name','asc')->get();
        $patients = Patient::where('user_id', auth()->user()->id)->select('id','name','phone')->where('status',1)->orderBy('name','asc')->get();
        return view('user.doctor.prescription.new',[
            'drugs'     =>  $drugs,
            'templates' =>  $template,
            'patients'  =>  $patients
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show all prescription page
     */
    public function allPrescription()
    {
        return view('user.doctor.prescription.all');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete an prescription by id
     */
    public function deletePrescription($id)
    {
        $prescription = Prescription::findOrFail($id);
        PrescriptionLeft::where('prescription_id', $id)->delete();
        PrescriptionDrug::where('prescription_id', $id)->delete();
        if ($prescription->delete()) {
            return redirect()->back()->with('delete_success', 'Prescription Has been deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save prescription
     */
    public function savePrescription(Request $request)
    {

        $prescription = new Prescription();
        $prescription->patient_id = $request->get('patient_id');
        $prescription->prescription_template_id = $request->get('template_id');
        $prescription->prescription_date = Carbon::now()->format('Y-m-d');
        $prescription->user_id = auth()->user()->id;
        $prescription->next_visit = $request->get('next_visit');
        if ($prescription->save()) {
            $this->markAppointmentAsChecked($prescription->patient_id);
            $prescription_left = new PrescriptionLeft();
            $prescription_left->prescription_id = $prescription->id;
            $prescription_left->cc = $request->get('cc');
            $prescription_left->oe = $request->get('oe');
            $prescription_left->pd = $request->get('pd');
            $prescription_left->dd = $request->get('dd');
            $prescription_left->lab_workup = $request->get('lab_workup');
            $prescription_left->advice = $request->get('advice');
            if ($prescription_left->save()) {
                foreach ($request->get('drugs') as $drug) {
                    $prescription_drug = new PrescriptionDrug();
                    $prescription_drug->prescription_id = $prescription->id;
                    $prescription_drug->drug_id = $drug['drug_id'];
                    $prescription_drug->type = $drug['drug_type'];
                    $prescription_drug->dose = $drug['dose'];
                    $prescription_drug->strength = $drug['strength'];
                    $prescription_drug->duration = $drug['duration'];
                    $prescription_drug->advice = $drug['drug_advice'];
                    $prescription_drug->save();
                }
                return response()->json($prescription, 200);
            }
        }
    }

    /**
     * @param $patient_id
     * Mark appointment status = 1 if patient appointment date is today
     */
    private function markAppointmentAsChecked($patient_id)
    {
        $appointment = PatientAppointment::where('patient_id',$patient_id)
        ->where('date',Carbon::today())->first();
        if($appointment){
            $appointment->status = 1;
            $appointment->save();
        }
    }
}
