<?php

namespace App\Http\Controllers;

use App\Model\PatientAppointment;
use App\Model\PatientPayment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\User;

use App\Model\Patient;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show new assistant page
     */
    public function newAssistant()
    {
        return view('user.doctor.assistant.new');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show edit assistant page
     */
    public function editAssistant($id)
    {
        $user = User::findOrFail($id);
        return view('user.doctor.assistant.edit',[
            'user'  =>  $user
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Delete assistant if not use in patient, payment or appointment
     */
    public function deleteAssistant($id)
    {
        $user = User::findOrFail($id);
        $user_in_appointment = PatientAppointment::where('user_id',$user->id)->first();
        $user_in_patient = Patient::where('user_id',$user->id)->first();
        $user_in_payment = PatientPayment::where('user_id',$user->id)->first();
        if(!$user_in_appointment && !$user_in_patient && !$user_in_payment){
            $user->delete();
            return redirect()->back()->with('delete_assistant','Assistant has been deleted');
        }else{
            return redirect()->back()->with('delete_fail','You cannot delete assistant');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Show all assistant page
     */
    public function allAssistant()
    {
        return view('user.doctor.assistant.all');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Save an assistant
     */
    public function saveAssistant(Request $request)
    {
        $request->validate([
            'email'     =>      'required|unique:users|max:255',
            'password'  =>      'required|min:5'
        ]);

        $user = new User();
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->password = Hash::make($request->get('password'));
        $user->role = 2;
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')
                ->move('uploads/assistant', rand(100000, 900000) . '.' . $request->image->extension());
        }
        if($user->save()){
            return response()->json([$user->name.' - Added',$user->name." Has been added as doctor assistant successfully"],'200');
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * Update an assistant
     */
    public function updateAssistant(Request $request,$id)
    {
        $request->validate([
            'email'     =>      'required|max:255',Rule::unique('users')->ignore($id),
            'name'      =>      'required|max:222',
            'phone'     =>      'required|max:255'
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        $user->status = $request->get('status') == 'on' ? 1 : 0;
        $user->role = 2;
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')
                ->move('uploads/assistant', rand(100000, 900000) . '.' . $request->image->extension());
        }
        if($user->save()){
            return response()->json([$user->name.' - Added',$user->name." Has been added as doctor assistant successfully"],'200');
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * show edit profile page
     */
    public function editProfile()
    {
        return view('user.doctor.setting.profile.edit-profile');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'email'     =>      'required|max:255',Rule::unique('users')->ignore(auth()->user()->id),
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->email = $request->get('email');
        $user->name = $request->get('name');
        $user->phone = $request->get('phone');
        $user->address = $request->get('address');
        $user->info = $request->get('info');
        if ($request->hasFile('image')) {
            $user->image = $request->file('image')
                ->move('uploads/assistant', rand(100000, 900000) . '.' . $request->image->extension());
        }
        if($user->save()){
            return response()->json([$user->name.' - Added',$user->name." Has been added as doctor assistant successfully"],'200');
        }
    }

}
