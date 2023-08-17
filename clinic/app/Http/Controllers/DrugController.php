<?php

namespace App\Http\Controllers;

use App\Model\PrescriptionDrug;
use App\Model\PrescriptionTemplateDrug;
use Illuminate\Http\Request;
use App\Model\Drug;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Validator;

class DrugController extends Controller
{
    /**
     * @param $id
     * @param $start_date
     * @param $end_date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     *
     */
    public function drugReport($id,$start_date,$end_date)
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

        $drugs = Drug::select('id','name')->get();
        $query = $id == 0 ? '>' : '=';
        $start_date = Carbon::parse($start_date)->toDateString();
        $end_date = Carbon::parse($end_date)->addDay(1)->toDateString();
        $drug_stat = PrescriptionDrug::where('drug_id',$query,$id)
            ->whereBetween('created_at',array($start_date,$end_date))
            ->get()
            ->groupBy(function ($query){
                return $query->created_at->format('M-Y');
            });

        return view('user.doctor.drug.drug-report',[
            'drugs'     =>      $drugs,
            'drug_id'   =>      $id,
            'drug_stat' =>      $drug_stat,
            'start'     =>      $start_date,
            'end'       =>      $end_date
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new drug page
     */
    public function newDrug()
    {
        return view('user.doctor.drug.new');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show all drug page
     */
    public function allDrug()
    {
        return view('user.doctor.drug.all');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show edit drug page
     */
    public function editDrug($id)
    {
        $drug = Drug::findOrFail($id);
        return view('user.doctor.drug.edit', [
            'drug'=>$drug
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete drug by id
     */
    public function deleteDrug($id)
    {
        $drug = Drug::findOrFail($id);
        $drug_in_template = PrescriptionTemplateDrug::where('drug_id',$id)->first();
        $drug_in_prescription = PrescriptionDrug::where('drug_id',$id)->first();
        if(!$drug_in_template && !$drug_in_prescription){
            $drug->delete();
            return redirect()->back()->with('delete_drug','Drug deleted');
        }else{
            return redirect()->back()->with('delete_fail','We cannot delete the drug');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug by form request
     */
    public function saveDrug(Request $request)
    {
        $request->validate([
            'name'          =>   'required|unique:drugs|max:255',
            'generic_name'  =>  'max:255'
        ]);

        $drug = new Drug();
        $drug->name = $request->get('name');
        $drug->generic_name = $request->get('generic_name');
        $drug->note = $request->get('note');
        $drug->user_id = auth()->user()->id;
        if ($drug->save()) {
            return response()->json([$drug->name.' - Drug Added',$drug->name." Has been added successfully"],'200');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update drug by form request
     */
    public function updateDrug(Request $request, $id)
    {
        $request->validate([
            'name'          =>   'required|max:255|'.Rule::unique('drugs')->ignore($id,'id'),
            'generic_name'  =>   'required|max:255'
        ]);
        $drug = Drug::findOrFail($id);
        $drug->name = $request->get('name');
        $drug->generic_name = $request->get('generic_name');
        $drug->note = $request->get('note');
        $drug->status = $request->get('status') == '' ? 0 : 1;
        $drug->user_id = auth()->user()->id;
        if ($drug->save()) {
            return response()->json([$drug->name.' - Drug updated',$drug->name." Has been updated successfully"],'200');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save drug in prescription page and response saved drug
     */
    public function saveNewDrug(Request $request)
    {
        $request->validate([
            'name'          =>   'required|unique:drugs|max:255',
            'generic_name'  =>  'max:255'
        ]);

        $drug = new Drug();
        $drug->name = $request->get('name');
        $drug->generic_name = $request->get('generic_name');
        $drug->user_id = auth()->user()->id;
        if ($drug->save()) {
            return response()->json($drug,200);
        }
    }
}
