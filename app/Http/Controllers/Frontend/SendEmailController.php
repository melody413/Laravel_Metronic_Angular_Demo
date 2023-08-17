<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

use App\Mail\NotifyMail;

class SendEmailController extends Controller
{

    public function sendEmail()
    {
        // dd(env('MAIL_USERNAME'));

        // Mail::to('asalabdo88@gmail.com')->send(new NotifyMail());
        // Mail::send('asalabdo88@gmail.com', $data, function($message) use ($email, $subject) {
        //     $message->to($email)->subject($subject);
        // });
        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        } else{
            return response()->success('Great! Successfully send in your mail');
        }
    }
}