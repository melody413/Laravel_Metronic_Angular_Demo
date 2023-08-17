<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest');
        \App::setLocale($request->get('lang'));
    }


    public function showRegistrationForm()
    {
        $type = request('doctor');
        return view('frontend.auth.register',compact('type'));
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => 'required|string|max:255',
            'phone' => 'required|min:10|max:12',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $birthdate = '';
        if($data['birthdate'])
            $birthdate = Carbon::createFromFormat('Y-m-d',$data['birthdate'])->format('Y-m-d');

        $type = User::USER_TYPE['user'];
        if($data['type'] == User::USER_TYPE['doctor'])
            $type = User::USER_TYPE['doctor'];

        $share_approved = isset($data['share_approved']) ? $data['share_approved'] : "";
        $live_approved = isset($data['live_approved']) ? $data['live_approved'] : "";
        $services_approved = isset($data['services_approved']) ? $data['services_approved'] : "";

        return User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'birthdate' => $birthdate,
            'dr_phone' => $data['dr_phone'],
            'phone' => $data['phone'],
            'specialties' => $data['specialties'],
            'specialty_in' => $data['specialty_in'],
            'address' => $data['bsCityies']." ".$data['address'],
            'facebook' => $data['ddfacebook'],
            'twitter' => $data['ddtwitter'],
            'instagram' => $data['instagram'],
            'share_approved' => $share_approved,
            'live_approved' => $live_approved,
            'services_approved' => $services_approved,
            'type' =>$type
        ]);
    }
}
