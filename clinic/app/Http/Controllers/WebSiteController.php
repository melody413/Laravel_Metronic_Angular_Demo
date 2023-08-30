<?php

namespace App\Http\Controllers;

use App\Model\About;
use App\Model\Appointment;
use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show appointment page
     */
    public function appointment()
    {
        $appointment = Appointment::where('user_id', auth()->user()->id);
        return view('website.appointment',[
            'appointments'  =>  $appointment
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save about me page
     */
    public function saveAboutMe(Request $request)
    {
        if(count(About::all()) == 0){
            $about = new About();

        }else{
            $about = About::first();
        }
        $about->about = $request->get('about');
        $about->save();
        return response()->json('ok',200);


    }
}
