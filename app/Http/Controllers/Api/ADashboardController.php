<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\DoctorBranch;
use App\Models\Pharmacy;
use App\Models\Lab;
use App\Models\Medicine;
use App\Models\InsuranceCompany;
use App\Models\Hospital;
use App\Models\Center;
use App\Models\User;
use App\Http\Controllers\Admin\BaseController;

class ADashboardController extends BaseController {


    public function home()
    {
        
        $doctors_count = Doctor::count();
        $doctors_last_date = Doctor::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $doctor_branches_count = DoctorBranch::count();
        $doctor_branches_last_date = DoctorBranch::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $pharmacy_count = Pharmacy::count();
        $pharmacy_last_date = Pharmacy::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $lab = Lab::count();
        $lab_last_date = Lab::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $insurance_company_count = InsuranceCompany::count();
        $insurance_company_last_date = InsuranceCompany::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $hospital_count = Hospital::count();
        $hospital_last_date = Hospital::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $center_count = Center::count();
        $center_last_date = Center::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $medicine_count = Medicine::count();
        $medicine_last_date = Medicine::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $user_count = User::count();
        $user_last_date = User::orderBy('created_at', 'desc')->first()->created_at->format('m/d/Y h:m');
        $user_normal_count = User::where('type', '1')->count();
        $user_doctor_count = User::where('type', '2')->count();
        $user_moderator_count = User::where('type', '3')->count();
        $user_admin_count = User::where('type', '4')->count();
        return response([
            'user_normal_count' => $user_normal_count,
            'user_doctor_count' => $user_doctor_count,
            'user_moderator_count' => $user_moderator_count,
            'user_admin_count' => $user_admin_count,
            'center_count' => $center_count,
            'center_last_date' => $center_last_date,
            'medicine_count' => $medicine_count,
            'medicine_last_date' => $medicine_last_date,
            'user_count' => $user_count,
            'user_last_date' => $user_last_date,
            'pharmacy_count' => $pharmacy_count,
            'pharmacy_last_date' => $pharmacy_last_date,
            'lab' => $lab,
            'lab_last_date' => $lab_last_date,
            'insurance_company_count' => $insurance_company_count,
            'insurance_company_last_date' => $insurance_company_last_date,
            'hospital_count' => $hospital_count,
            'hospital_last_date' => $hospital_last_date,
            'doctors_count' => $doctors_count,
            'doctor_branches_count' => $doctor_branches_count,
            'doctors_last_date' => $doctors_last_date,
            'doctor_branches_last_date' => $doctor_branches_last_date,
        ], 200);
            
    }

    protected function getTemplateFolder()
    {
        return 'dashboard';
    }
}