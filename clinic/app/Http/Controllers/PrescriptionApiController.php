<?php

namespace App\Http\Controllers;

use App\Model\Advice;
use App\Model\DrugAdvice;
use App\Model\DrugDose;
use App\Model\DrugDuration;
use App\Model\DrugStrength;
use App\Model\DrugType;
use App\Model\Patient;
use App\Model\PatientAppointment;
use App\Model\Prescription;
use App\Model\PrescriptionTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrescriptionApiController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response template by id with drug and prescription template left table
     */
    public function getTemplateDetails($id)
    {
        $template = PrescriptionTemplate::where('id',$id)
            ->with('drugs')
            ->with('prescriptionTemplateLeft')
            ->firstOrFail();
        return response()->json($template);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response presciption by id with durgs and prescription left
     */
    public function getPrescriptionDetails($id)
    {
        $prescription = Prescription::with('drugs')
            ->with('prescriptionLeft')
            ->findOrFail($id);
        return response()->json($prescription);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response patient details and patient age (form today)
     */
    public function getPatientDetails($id)
    {
        $patient = Patient::with('prescriptions')->findOrFail($id);
        $age = $patient->age();
        return response()->json(['patient'=>$patient,'age'=>$age]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * API response drug types
     */
    public function getDrugTypes()
    {
        $drug_types = DrugType::select('type')->where('status',1)->get();
        return response()->json($drug_types);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * API response drug doses
     */
    public function getDrugDose()
    {
        $drug_dose = DrugDose::select('dose')->where('status',1)->get();
        return response()->json($drug_dose);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * API response drug duration
     */
    public function getDrugDuration()
    {
        $drug_duration = DrugDuration::select('duration')->where('status',1)->get();
        return response()->json($drug_duration);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * API response drug strength
     */
    public function getDrugStrength()
    {
        $drug_strength = DrugStrength::select('strength')->where('status',1)->get();
        return response()->json($drug_strength);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * API response drug advice
     */
    public function getDrugAdvice()
    {
        $drug_advice = DrugAdvice::select('drug_advice')->where('status',1)->get();
        return response()->json($drug_advice);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * API response get advice
     */
    public function getAdvice()
    {
        $advice = Advice::select('advice')->where('status',1)->get();
        return response()->json($advice);
    }






}
