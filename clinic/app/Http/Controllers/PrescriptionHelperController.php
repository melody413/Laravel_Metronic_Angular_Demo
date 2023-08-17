<?php

namespace App\Http\Controllers;

use App\Model\DrugAdvice;
use App\Model\DrugDose;
use App\Model\DrugDuration;
use Illuminate\Http\Request;
use App\Model\DrugType;
use App\Model\DrugStrength;
use Illuminate\Validation\Rule;

class PrescriptionHelperController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Drug Type
    |--------------------------------------------------------------------------
    |*/

    /*
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     * Delete a drug type by drug type id
     */
    public function deleteDrugType($id)
    {
        $drug_type = DrugType::findOrFail($id);
        if($drug_type->delete()){
            return redirect()->back()->with('delete_drug_type','Drug type deleted');
        }else{
            return redirect()->back()->with('delete_fail',"Delete fail");
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug type
     */
    public function saveDrugType(Request $request)
    {
        $request->validate([
           'type'  =>  'required|unique:drug_types|max:255'
        ]);
        $drug_type = new DrugType();
        $drug_type->type = $request->get('type');
        $drug_type->user_id = auth()->user()->id;
        if ($drug_type->save()) {
            return response()->json(['Drug Type Saved','Drug type saved successfully'], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update drug type
     */
    public function updateDrugType(Request $request, $id)
    {
        $request->validate([
            'type'  =>  'required',Rule::unique('drug_types')->ignore($id),
        ]);
        $drug_type = DrugType::findOrFail($id);
        $drug_type->type = $request->get('type');
        $drug_type->status = $request->get('status') == '' ? 0 : 1;
        $drug_type->user_id = auth()->user()->id;
        if ($drug_type->save()) {
            return response()->json(['Drug Type Updated','Drug type updated successfully'], 200);

        }
    }
    /***************************************************************************
     ** Drug Strength
     ***************************************************************************/

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete drug strength
     */
    public function deleteDrugStrength($id)
    {
        $drug_strength = DrugStrength::findOrFail($id);
        if($drug_strength->delete()){
            return redirect()->back()->with('delete_strength','Delete drug strength successfully');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug strength
     */
    public function saveDrugStrength(Request $request)
    {
        $request->validate([
            'strength'  =>  'required|unique:drug_strengths|max:255'
        ]);
        $drug_strength = new DrugStrength();
        $drug_strength->strength = $request->get('strength');
        $drug_strength->user_id = auth()->user()->id;
        if ($drug_strength->save()) {
            return response()->json(['Drug Strength Saved','Drug strength saved successfully'], 200);

        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update drug strength
     */
    public function updateDrugStrength(Request $request, $id)
    {
        $request->validate([
            'strength'  =>  'required',Rule::unique('drug_strengths')->ignore($id)
        ]);
        $drug_strength = DrugStrength::findOrFail($id);
        $drug_strength->strength = $request->get('strength');
        $drug_strength->status = $request->get('status') == '' ? 0 : 1;
        $drug_strength->user_id = auth()->user()->id;
        if ($drug_strength->save()) {
            return response()->json(['Drug Strength updated','Drug strength updated successfully'], 200);

        }
    }

    /*------------------------------------------------------------------------------------
     | Drug Dose
     -------------------------------------------------------------------------------------*/


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug dose
     */
    public function saveDrugDose(Request $request)
    {
        $request->validate([
            'dose'  =>  'required|unique:drug_doses|max:255'
        ]);
        $drug_dose = new DrugDose();
        $drug_dose->dose = $request->get('dose');
        $drug_dose->user_id = auth()->user()->id;
        if($drug_dose->save()){
            return response()->json(['Drug Dose Saved','Drug dose saved successfully'], 200);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete drug dose
     */
    public function deleteDrugDose($id)
    {
        if(DrugDose::destroy($id)){
            return redirect()->back()->with('drug_dose_delete','Drug Dose delete');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update drug dose
     */
    public function updateDrugDose(Request $request,$id)
    {
        $request->validate([
            'dose'  =>  'required',Rule::unique('drug_doses')->ignore($id)
        ]);
        $drug_dose = DrugDose::findOrFail($id);
        $drug_dose->dose = $request->get('dose');
        $drug_dose->status = $request->get('status') == 'on' ? 1 : 0;
        $drug_dose->user_id = auth()->user()->id;
        if($drug_dose->save()){
            return response()->json(['Drug Dose Saved','Drug dose saved successfully'], 200);
        }
    }

    /************************
     * Drug Duration        *
     ************************/
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete drug duration by drug duration id
     */
    public function deleteDrugDuration($id)
    {
        if(DrugDuration::destroy($id)){
            return redirect()->back()->with('delete_drug_duration','Drug duration deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug duration
     */
    public function saveDrugDuration(Request $request)
    {
        $request->validate([
            'duration'  =>  'required|unique:drug_durations|max:255'
        ]);
        $drug_duration = new DrugDuration();
        $drug_duration->duration = $request->get('duration');
        $drug_duration->user_id = auth()->user()->id;
        if($drug_duration->save()){
            return response()->json(['Drug Duration Saved','Drug Duration saved successfully'], 200);

        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update drug duration
     */
    public function updateDrugDuration(Request $request,$id)
    {
        $request->validate([
            'duration'  =>  'required',Rule::unique('drug_durations')->ignore($id)
        ]);
        $drug_duration =  DrugDuration::findOrFail($id);
        $drug_duration->duration = $request->get('duration');
        $drug_duration->status = $request->get('status') == 'on' ? 1 : 0;
        $drug_duration->user_id = auth()->user()->id;
        if($drug_duration->save()){
            return response()->json(['Drug Duration updated','Drug Duration updated successfully'], 200);
        }
    }

    /**
     * Drug Advice
     */
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete drug advice
     */
    public function deleteDrugAdvice($id)
    {
        if(DrugAdvice::destroy($id)){
            return redirect()->back()->with('delete_drug_advice','Drug advice deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug advice
     */
    public function saveDrugAdvice(Request $request)
    {
        $request->validate([
            'drug_advice'  =>  'required|unique:drug_advices|max:255'
        ]);
        $drug_advice = new DrugAdvice();
        $drug_advice->drug_advice  = $request->get('drug_advice');
        $drug_advice->user_id  = auth()->user()->id;
        if($drug_advice->save()){
            return response()->json(['Drug Advice saved','Drug advice saved successfully'], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update drug advice
     */
    public function updateDrugAdvice(Request $request,$id)
    {
        $request->validate([
            'drug_advice'  =>  'required',Rule::unique('drug_advices')->ignore($id)
        ]);
        $drug_advice =  DrugAdvice::findOrFail($id);
        $drug_advice->drug_advice  = $request->get('drug_advice');
        $drug_advice->status  = $request->get('status') == 'on' ? 1 : 0;
        $drug_advice->user_id  = auth()->user()->id;
        if($drug_advice->save()){
            return response()->json(['Drug Advice saved','Drug advice saved successfully'], 200);
        }
    }

    // Apis

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response drug type details
     */
    public function getDrugTypeDetails($id)
    {
        $drug_type = DrugType::findOrFail($id);
        return response()->json($drug_type);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response drug strength details
     */
    public function getDrugStrengthDetails($id)
    {
        $drug_strength = DrugStrength::findOrFail($id);
        return response()->json($drug_strength);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response drug dose details
     */
    public function getDrugDoseDetails($id)
    {
        $drug_dose = DrugDose::findOrFail($id);
        return response()->json($drug_dose);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response drug duration details
     */
    public function getDrugDurationDetails($id)
    {
        $drug_duration = DrugDuration::findOrFail($id);
        return response()->json($drug_duration);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * API response drug advice details
     */
    public function getDrugAdviceDetails($id)
    {
        $drug_advice = DrugAdvice::findOrFail($id);
        return response()->json($drug_advice);
    }
}
