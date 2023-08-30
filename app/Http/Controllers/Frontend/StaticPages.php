<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

use App\Mail\NotifyMail;

class StaticPages extends BaseController
{
    public function termsAndConditions()
    {
        $lang = \App::getLocale()=='ar' ? 'is_rtl' : 'is_ltr';
        return view('frontend.static_pages.terms_and_conditions_ar', compact('lang'));
    }

    public function contactUs()
    {
        return view('frontend.static_pages.contact_us');
    }

    public function tickets()
    {
        $lang = \App::getLocale()=='ar' ? 'is_rtl' : 'is_ltr';
        return view('frontend.static_pages.tickets');
    }

    public function sendEmail(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'g-recaptcha-response' => 'required|captcha'

        ]);

        $status = Mail::to('asalabdo88@gmail.com')->send(new NotifyMail($request->name, $request->phone,$request->email,$request->message));
        $status = Mail::to('info@doctorak.com')->send(new NotifyMail($request->name, $request->phone,$request->email,$request->message));
        // dd($status);
        return redirect(route('frontend.home'));

        // Mail::to('info@doctorak.com')->send(new NotifyMail());

        // $to = "asalabdo88@gmail.com";
        // $subject = "This is subject";

        // $message = "<b>This is HTML message.</b>";
        // $message .= "<h1>This is headline.</h1>";

        // $header = "From:abc@doctorak.com \r\n";
        // $header .= "MIME-Version: 1.0\r\n";
        // $header .= "Content-type: text/html\r\n";

        // $status = mail ($to,$subject,$message,$header);

        $redirectMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];
        $redirectFailedMsg = [
            'flash_message' => trans('admin.failed_message') ,
            'flash_type' => 'success' ,
        ];

        if($status)
            return redirect(route('frontend.staticPages.contactUs'))->with($redirectMsg);

        return redirect(route('frontend.staticPages.contactUs'))->with($redirectFailedMsg);
    }

    public function calc($type)
    {
        return view('frontend.static_pages.calc', ['type' => $type]);
    }

    protected function getTemplateFolder()
    {
        return 'static_pages';
    }
}
