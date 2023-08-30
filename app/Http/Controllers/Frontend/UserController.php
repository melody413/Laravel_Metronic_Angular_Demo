<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Doctor;
use App\Models\DoctorReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends BaseController
{
    private $user;


    public function profile()
    {
        $user = $this->getUser();
        return view($this->getTemplatePath('profile'), compact('user'));
    }

    public function storeProfile(Request $request)
    {
        $row = $this->getUser();
        $postData = $request->except('_token');

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|min:10|max:12',
            'email' => 'required|string|email|max:255|unique:users,id,' . $row->id,
        ]);

        $row->update($postData);

        $redirctMsg = [
            'flash_message' => trans('save_success_message') ,
            'flash_type' => 'success' ,
        ];

        return redirect(route('frontend.user.profile'))->with($redirctMsg);
    }

    public function changePassword()
    {
        return view($this->getTemplatePath('change_password'));
    }

    public function storeNewPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $row = $this->getUser();
        $postData = $request->except('_token');

        $row->update(['password' => Hash::make($postData['password'])]);

        $redirctMsg = [
            'flash_message' => trans('save_success_message') ,
            'flash_type' => 'success' ,
        ];

        return redirect(route('frontend.user.profile'))->with($redirctMsg);
    }

    public function reservation()
    {
        if( ! Auth::check() || Auth::user()->type != User::USER_TYPE['user'] )
            return redirect(route('frontend.home'));

        $reserve = DoctorReservation::where('user_id', Auth::user()->id)->with(['doctor', 'branch'])->orderBy('updated_at', 'DESC')->paginate();

        return view($this->getTemplatePath('my_reservation'), compact(['reserve']));
    }

    public function doctorReservations()
    {
        if( ! Auth::check() || Auth::user()->type != User::USER_TYPE['doctor'] )
            return redirect(route('frontend.home'));

        $doctor = Doctor::where('user_id', Auth::user()->id)->first();
        $reserve = null;
        if( $doctor )
            $reserve = DoctorReservation::where('doctor_id', $doctor->id)->with(['branch'])->orderBy('updated_at', 'DESC')->paginate();

        return view($this->getTemplatePath('reservation'), compact(['reserve']));
    }

    protected function getUser()
    {
        return User::findOrFail(Auth::user()->id);
    }

    public function getTemplateFolder()
    {
        return 'user';
    }
}
