<?php

namespace App\Http\Controllers;

use App\Model\Appointment;
use App\Model\PatientAppointment;
use App\Model\PatientDocument;
use App\Model\PatientPayment;
use App\Model\Prescription;
use App\Traits\PatientFilter;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Model\Patient;

use App\User;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    use PatientFilter;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new patient page
     */
    public function newPatient()
    {
        return view('user.doctor.patient.new');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show patient details page
     */
    public function viewPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('user.doctor.patient.view', [
            'patient' => $patient
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show patient medical file
     */
    public function patientMedicalFile($id)
    {
        $patient = Patient::findOrFail($id);
        return view('user.doctor.patient.medical-files.new-file', [
            'patient' => $patient
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show patient medial history
     */
    public function patientMedicalHistory($id)
    {
        $patient = Patient::findOrFail($id);
        return view('user.doctor.patient.medical-history', [
            'patient' => $patient
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show edit patient page
     */
    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return view('user.doctor.patient.edit', [
            'patient' => $patient
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * Show All Patient page
     */
    public function allPatient(Request $request)
    {
//        return $this->filteredPatient($request);
        return view('user.doctor.patient.all', [
            'patients' => $this->filteredPatient($request)
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete a patient by patient id
     */
    public function deletePatient($id)
    {
        $patient = Patient::findOrFail($id);
        PatientPayment::where('patient_id', $id)->delete();
        Prescription::where('patient_id', $id)->delete();
        PatientDocument::where('patient_id', $id)->delete();
        PatientAppointment::where('patient_id', $id)->delete();
        if ($patient->delete()) {
            return redirect()->back()->with('delete_patient', 'Patient has been deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save new patient
     */
    public function savePatient(Request $request)
    {
        $request->validate([
            'phone' => 'required|unique:patients|max:255',
            'date_of_birth' => 'required|date'
        ]);

        $patient = new Patient();
        $patient->name = $request->get('name');
        $patient->gender = $request->get('gender');
        $patient->date_of_birth = Carbon::parse($request->get('date_of_birth'))->format('Y-m-d');
        $patient->email = $request->get('email');
        $patient->address = $request->get('address');
        $patient->phone = $request->get('phone');
        $patient->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {
            $patient->image = $request->file('image')
                ->move('uploads/patient', rand(100000, 900000) . '.' . $request->image->extension());
        }
        if ($patient->save()) {
            return response()->json($patient, 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update and patient by patient id
     */
    public function updatePatient(Request $request, $id)
    {
        $request->validate([
            'phone' => 'required', Rule::unique('patients')->ignore($id),
            'date_of_birth' => 'required|date'
        ]);
        $patient = Patient::findOrFail($id);
        $patient->name = $request->get('name');
        $patient->gender = $request->get('gender');
        $patient->date_of_birth = $request->get('date_of_birth');
        $patient->email = $request->get('email');
        $patient->address = $request->get('address');
        $patient->phone = $request->get('phone');
        $patient->user_id = auth()->user()->id;
        if ($patient->save()) {
            return response()->json(['Patient updated', 'Patient Updated successfully'], 200);
        }
    }

    /**
     * @param Request $request
     * @param $patient_id
     * @return \Illuminate\Http\RedirectResponse
     * Save medical file of patient
     */
    public function saveMedicalFile(Request $request, $patient_id)
    {
        $patient_document = new PatientDocument();
        $patient_document->patient_id = $patient_id;
        $patient_document->prescription_id = 0;
        $patient_document->type = 1;
        if ($request->hasFile('image')) {
            $patient_document->path = $request->file('image')
                ->move('uploads/medical_files', rand(100000, 900000) . '.' . $request->image->extension());
        }
        $patient_document->user_id = auth()->user()->id;
        if ($patient_document->save()) {
            return redirect()->back();
        }

    }

    public function deleteMedicalFile($id)
    {
        if (PatientDocument::destroy($id)) {
            return redirect()->back()->with('medical_file_delete', 'Medical File Delete');
        }
    }

}
