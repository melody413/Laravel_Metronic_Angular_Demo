<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class DataFormController extends BaseController
{
    public function pharamcyInfo(Request $request)
    {
        return dataForm()->getPharmayInfo($request->route('id'));
    }

    public function LabInfo(Request $request)
    {
        return dataForm()->getLabInfo($request->input('id'));
    }

    public function getHospitals(Request $request)
    {
        return dataForm()->getHospitals($request->input('query'));
    }

    public function getCenters(Request $request)
    {
        return dataForm()->getCenters($request->input('query'));
    }

    public function getInsuranceCompanies(Request $request)
    {
        return dataForm()->getInsuranceCompanyByName($request->route('query'));
    }

    public function getSubsBySub(Request $request)
    {
        return dataForm()->getSubsBySub($request->route('q'));
    }

    public function getSubsBySpecialty(Request $request)
    {
        return dataForm()->getSubsBySpecialty($request->route('q'));
    }

    public function getSymptomsByBodyPart(Request $request)
    {
        return dataForm()->getSymptomsByBodyPart($request->route('q'));
    }

    public function uploadImages(Request $request)
    {
        if($request->hasFile('file'))
        {
            $image = $this->moveFile($request->file('file') , $request->input('path') . '/');
            return $image;
        }

        return 'Error';
    }

    public function getUser(Request $request)
    {
        return dataForm()->getUsers($request->route('query'));
    }

    protected function getTemplateFolder()
    {
        // TODO: Implement getTemplateFolder() method.
    }
}
