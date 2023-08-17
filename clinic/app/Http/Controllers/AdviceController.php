<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Advice;
use Illuminate\Validation\Rule;

class AdviceController extends Controller
{

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete advice
     */
    public function deleteAdvice($id)
    {
        $advice = Advice::findOrFail($id);
        if($advice->delete()){
            return redirect()->back()->with('advice_delete','Advice has been deleted');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save advice to database
     */
    public function saveAdvice(Request $request)
    {
        $request->validate([
           'advice' =>  'required|unique:advices|max:255'
        ]);
        $advice = new Advice();
        $advice->advice = $request->get('advice');
        $advice->user_id = auth()->user()->id;
        if ($advice->save()) {
            return response()->json(['Advice saved','advice saved successfully'], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update advice by advice id
     */
    public function updateAdvice(Request $request, $id)
    {
        $request->validate([
            'advice' =>  'required|max:255',Rule::unique('advices')->ignore($id)
        ]);
        $advice = Advice::findOrFail($id);
        $advice->advice = $request->get('advice');
        $advice->status = $request->get('status') == '' ? 0 : 1;
        $advice->user_id = auth()->user()->id;
        if ($advice->save()) {
            return response()->json(['Advice updated','Drug updated successfully'], 200);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Advice details by id
     */
    public function getAdviceDetails($id)
    {
        $advice = Advice::findOrfail($id);
        return response()->json($advice);
    }
}
