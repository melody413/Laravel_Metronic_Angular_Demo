<?php

namespace App\Http\Controllers;

use App\Model\Drug;
use App\Model\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Model\PrescriptionTemplate;
use App\Model\PrescriptionTemplateLeft;
use App\Model\PrescriptionTemplateDrug;
use Validator;

class TemplateController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new template page
     */
    public function newTemplate()
    {
        $drugs = Drug::where('status',1)->orderBy('name','asc')->get();
        return view('user.doctor.template.new',[
            'drugs'    =>  $drugs
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show edit template page with template and drugs
     */
    public function editTemplate($id)
    {
        $template = PrescriptionTemplate::findOrFail($id);
        $drugs = Drug::where('status',1)->orderBy('name','asc')->get();
        return view('user.doctor.template.edit', [
            'template'    =>    $template,
            'drugs'       =>    $drugs
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show all template page
     */
    public function allTemplate()
    {
        return view('user.doctor.template.all');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show template as printable
     */
    public function viewTemplate($id)
    {
        $template = PrescriptionTemplate::findOrFail($id);
        return view('user.doctor.template.view',[
            'template'      =>      $template
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete an template if not use in prescription
     */
    public function deleteTemplate($id)
    {
        $template = PrescriptionTemplate::findOrFail($id);
        $template_in_prescription = Prescription::where('user_id', auth()->user()->id)->where('prescription_template_id',$id)->first();
        if(!$template_in_prescription){
            $template->delete();
            return redirect()->back()->with('delete_template','Tempalte delete');
        }else{
            return redirect()->back()->with('delete_fail','DElete faild');
        }
    }

    /**
     * @param Request $request
     * Save template
     */
    public function saveTemplate(Request $request)
    {
        $template = new PrescriptionTemplate();
        $this->saveTemplateDetails($template,$request);
    }

    /**
     * @param Request $request
     * @param $id
     * Update template
     */
    public function updateTemplate(Request $request, $id)
    {
        $template = PrescriptionTemplate::findOrFail($id);
        $this->deleteTemplateDetails($id);
        $this->saveTemplateDetails($template,$request);
    }

    /**
     * @param $template
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * helper function who will save or update prescription by given variable
     */
    private function saveTemplateDetails($template,$request)
    {
        $template->name = $request->get('name') != "" | null ? $request->get('name') : 'Prescription Template'.PrescriptionTemplate::where('id','>','0')->count() .time();
        $template->note = $request->get('note');
        $template->advice = $request->get('advice');
        $template->user_id = auth()->user()->id;
        if ($template->save()) {
            $template_left = new PrescriptionTemplateLeft();
            $template_left->prescription_template_id = $template->id;
            $template_left->cc = $request->get('cc');
            $template_left->oe = $request->get('oe');
            $template_left->pd = $request->get('pd');
            $template_left->dd = $request->get('dd');
            $template_left->lab_workup = $request->get('lab_workup');
            $template_left->advice = $request->get('advice');
            if ($template_left->save()) {
                foreach ($request->get('drugs') as $drug) {
                    $template_drug = new PrescriptionTemplateDrug();
                    $template_drug->prescription_template_id = $template->id;
                    $template_drug->drug_id = $drug['drug_id'];
                    $template_drug->dose = $drug['dose'];
                    $template_drug->duration = $drug['duration'];
                    $template_drug->strength = $drug['strength'];
                    $template_drug->advice = $drug['drug_advice'];
                    $template_drug->type = $drug['drug_type'];
                    $template_drug->save();
                }
                return response()->json(['template'=>$template->name], 200);
            }
        }
    }

    /**
     * @param $id
     * Delete template details
     */
    private function deleteTemplateDetails($id)
    {
        PrescriptionTemplateLeft::where('prescription_template_id', $id)->delete();
        PrescriptionTemplateDrug::where('prescription_template_id', $id)->delete();
    }

    /**
     * @param $id
     * @param $start_date
     * @param $end_date
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * Return template report page with filter
     */
    public function templateReport($id,$start_date,$end_date)
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
        $start_date = Carbon::parse($start_date)->toDateString();
        $end_date = Carbon::parse($end_date)->addDay(1)->toDateString();


        $query = $id == 0 ? '>' : '=';
        $templates = PrescriptionTemplate::select('id','name')->get();

        $stat_template = Prescription::where('user_id', auth()->user()->id)->where('prescription_template_id',$query,$id)
            ->whereBetween('created_at',array($start_date,$end_date))
            ->get()
            ->groupBy(function ($query){
                return $query->created_at->format('M-Y');
            });
        return view('user.doctor.template.report',[
            'templates'     =>     $templates,
            'start'         =>     $start_date,
            'end'           =>     $end_date,
            'template_id'   =>     $id,
            'stat_template' =>     $stat_template
        ]);
    }
}
