<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class CaptchaValidationController extends BaseController {

    public function index()
    {
        return view('form-with-captcha');
    }
 
    public function capthcaFormValidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'captcha' => 'required|captcha'
        ]);
    }
 
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }


    public function getTemplateFolder()
    {
        return 'captcha';
    }
 
}