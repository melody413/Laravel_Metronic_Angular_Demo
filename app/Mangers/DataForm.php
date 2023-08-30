<?php
namespace App\Mangers;

use App\Models\AdminMenu;
use App\Models\Area;
use App\Models\Center;
use App\Models\City;
use App\Models\Country;
use App\Models\Hospital;
use App\Models\InsuranceCompany;
use App\Models\Medicine;
use App\Models\MedicinesCompany;
use App\Models\MedicinesScName;
use App\Models\Lab;
use App\Models\LabCompany;
use App\Models\PharmacyCompany;
use App\Models\LabService;
use App\Models\Pharmacy;
use App\Models\Role;
use App\Models\Specialty;
use App\Models\HospitalType;
use App\Models\MedicinesCategory;
use App\Models\SpecialtySubCategory;
use App\Models\SubCategory;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class DataForm
{
    private function __construct()
    {

    }

    public static $cities, $areas, $pharmacies, $speciality, $labs, $companies, $hospital_type, $sc_companies, $medicinesScName, $form ;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DataForm();
        }
        return $inst;
    }

    public static function getCountries()
    {
        return Country::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
    }

    public static function getCities($country = null)
    {
        if(!$country)
            $country = getCountry()->id;

        #->where('locale', LaravelLocalization::getCurrentLocale() )
        if(!isset(self::$cities))
            self::$cities = City::where('is_active', 1)->where('country_id', $country)->withTranslation('name')->get()->pluck('name','id');

        return self::$cities;
    }

    public static function getAreas($city)
    {
        $aa = Area::where('is_active', 1)->where('city_id', $city)->translatedIn('en')->get()->pluck('name','id');
        return $aa;
    }

    public function getParentPharmacies()
    {
        return Pharmacy::where('is_active' , 1)->whereNull('parent_id')->listsTranslations()->get()->pluck('name','id');;
    }

    public function getPharmayInfo($id)
    {
        return Pharmacy::where('is_active' , 1)->where('id', $id)->whereNull('parent_id')->first();
    }

    public function getParentLab()
    {
        return Lab::where('is_active' , 1)->whereNull('parent_id')->listsTranslations('name')->pluck('name','id');
    }
    public function getLabCompanies()
    {
        return LabCompany::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
    }
    public function getPharmacyCompanies()
    {
        return PharmacyCompany::where('is_active' , 1)->listsTranslations('name')->pluck('name','id');
    }

    public function getLabInfo($id)
    {
        return Lab::where('is_active' , 1)->where('id', $id)->whereNull('parent_id')->first();
    }

    public function getLabServices()
    {
        if(!isset(self::$labs))
            self::$labs =  LabService::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$labs;

    }

    public function getSpeciality()
    {
        if(!isset(self::$speciality))
            self::$speciality = Specialty::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$speciality;
    }

    public function getHospitalTypes()
    {
        if(!isset(self::$hospital_type))
            self::$hospital_type = HospitalType::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$hospital_type;
    }

    public function getAdminMenu()
    {
        $adminMenu = AdminMenu::where('is_active', 1)
            ->where('in_menu', 1)
            ->whereNull('parent_id')
            ->orderBy('display_order', 'DESC')
            ->get();


        $returnAdminMenu = [];
        foreach($adminMenu as $k=>$row)
        {
            $submenu = [];
            foreach($row->getActiveSubMenus() as $s=>$sub)
            {
                if( Auth::user()->can($sub->route_name) )
                    $submenu[] = $sub;
            }

            if ( $submenu )
            {
                $returnAdminMenu[$k] = [
                    'url' => $row->url,
                    'title' => $row->title,
                    'icon' => $row->icon,
                    'has_sub' => $row->has_sub,
                    'submenus' => $submenu
                ];
            }
        }

        return $returnAdminMenu;
    }

    public function getAdminRouteInfo()
    {
        $ex = explode('Admin\\',Route::getCurrentRoute()->getActionName());

        $ex1 = explode('@',  $ex[1]);
        $route = explode('Controller',  $ex1[0]);

        return[
            'controller' => $route[0],
            'action' => $ex1[1]
        ];
    }

    public function getHospitals($q)
    {
        return Hospital::where('is_active', 1)
            ->whereTranslationLike('name', '%'. $q .'%')->take(10)
            ->get()
            ;
    }

    public function getCenters($q)
    {
        return Center::where('is_active', 1)
            ->whereTranslationLike('name', '%'. $q .'%')->take(10)
            ->get()
            ;
    }

    public function getUsers($q, $type = User::USER_TYPE['doctor'])
    {
        return User::where('email', 'like','%'. $q .'%')
            //->where('type', $type)
            ->get()
            ;
    }

    public function getInsuranceCompanyByName($q)
    {
        return InsuranceCompany::where('is_active', 1)
            ->whereTranslationLike('name', '%'. $q .'%')
            ->get()
            ;
    }

    public function getSubsBySub($q)
    {
        return SubCategory::where('is_active', 1)
            // ->where('parent', 'like', '%"'. $q .'"%')
            ->whereIn('parent', explode(",\"", $q."\""))
            ->get()
            ;
    }

    public function getSubsBySpecialty($q)
    {
        return SpecialtySubCategory::whereIn('specialty_id', explode(",", $q))
                ->join('sub_category_trans', function ($join) {
                    $join->on('specialty_sub_category.sub_category_id', '=', 'sub_category_trans.sub_category_id')
                        ->where('sub_category_trans.locale', 'ar')
                        // ->whereNull('specialty_sub_category.parent')
                        ;
                })
                ->get()
                ;
    }

    public function getSymptomsByBodyPart($q)
    {
        // return Symptom::whereIn('body_part_ids', explode(",", $q))
        //         ->join('body_part_trans', function ($join) {
        //             $join->on('specialty_body_part.body_part_id', '=', 'body_part_trans.body_part_id')
        //                 ->where('body_part_trans.locale', 'ar')
        //                 // ->whereNull('specialty_sub_category.parent')
        //                 ;
        //         })
        //         ->get()
        //         ;
        // dd($q);
        return Symptom::where('is_active', 1)
                ->where('body_parts_ids', 'like', '%'. $q .'%')
                // ->whereIn('body_parts_ids', explode(",\"", $q."\""))
                ->get()
                ;
    }

    public function getInsuranceCompany()
    {
        if(!isset(self::$companies))
            self::$companies = InsuranceCompany::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$companies;

    }
    public function getMedicineCompany()
    {
        if(!isset(self::$companies))
            self::$companies = MedicinesCompany::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$companies;

    }

    public function getMedicineCategory()
    {
        if(!isset(self::$companies))
            self::$companies = MedicinesCategory::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$companies;

    }
    public function getMedicineForm()
    {
        if(app('laravellocalization')->getDefaultLocale() == "en")
            $form[] = [
            "Choose",
            "Tablets" => "Tablets",
            "Capsule" => "Capsule",
            "Ampoules" => "Ampoules",
            "Syrup" => "Syrup",
            "Cream" => "Cream",
            "Sachets" => "Sachets",
            "Lotion" => "Lotion",
            "Drops" => "Drops",
            "Antiseptic_Solution" => "Antiseptic_Solution",
            "Infant_Milk" => "Infant_Milk",
            "Mouth_Wash" => "Mouth_Wash",
            "Tea_bag" => "Tea_bag",
            "Powder" => "Powder",
            "Infusion" => "Infusion",
            "Inhalation" => "Inhalation",
            "Hair_Oil" => "Hair_Oil",
            "Lozenges" => "Lozenges",
            "Oral_Drops" => "Oral_Drops",
            "Vial" => "Vial",
            "Suppository" => "Suppository",
            "Vag" => "Vag",
            "foam_spray" => "foam_spray",
            "solution" => "solution",
            "Emulsion" => "Emulsion",
            "Liquid" => "Liquid",
            "Oint" => "Oint",
            "inhaln" => "inhaln",
            "Spray" => "Spray",
            "Gel" => "Gel",
            "Volatile" => "Volatile",
            "bottle" => "bottle",
            "sprayer" => "sprayer",
            "soap" => "soap",
            "shampoo" => "shampoo",
            "hair_lotion" => "hair lotion",
            "serum" => "serum",
            "mask" => "mask",
            "Condition" => "Condition",
            "hair_ampoules" => "hair ampoules",
            "bath_oil" => "bath oil"];
        else
            $form[] = [
            "" => "الشكل الدوائي",
            "Tablets" => "اقراص",
            "Capsule" => "كبسولات",
            "Ampoules" => "أمبول",
            "Syrup" => "شراب",
            "Cream" => "كريم",
            "Sachets" => "أكياس",
            "Lotion" => "لوشن",
            "Drops" => "قطرات",
            "Antiseptic_Solution" => "محلول مطهر",
            "Infant_Milk" => "لبن اطفال",
            "Mouth_Wash" => "غسول الفم",
            "Tea_bag" => "أكياس شاي",
            "Powder" => "بودرة",
            "Infusion" => "محلول معلق",
            "Inhalation" => "بخاخة للصدر",
            "Hair_Oil" => "زيت الشعر",
            "Lozenges" => "استحلاب",
            "Oral_Drops" => "قطرة فم",
            "Vial" => "امبول",
            "Suppository" => "لبوس",
            "Vag" => "دش مهبلي",
            "foam_spray" => "بخاخ فوم",
            "solution" => "المحلول",
            "Emulsion" => "مستحلب",
            "Liquid" => "سائل",
            "Oint" => "مرهم",
            "inhaln" => "استنشاق",
            "Spray" => "رذاذ",
            "Gel" => "جل",
            "Volatile" => "متطايرة",
            "bottle" => "زجاجة",
            "sprayer" => "بخاخ",
            "soap" => "صابون",
            "shampoo" => "شامبو",
            "hair_lotion" => "غسول الشعر",
            "serum" => "سيروم",
            "mask" => "ماسك",
            "Condition" => "بلسم",
            "hair_ampoules" => "أمبولات الشعر",
            "bath_oil" => "زيت الاستحمام"];
//         if(!isset(self::$form))
//             self::$form = Medicine::where('is_active', 1)->groupBy('form')->withTranslation()->latest()->get();
// dd(self::$form);
        return $form;

    }
    public function getMedicineScientificName1()
    {
        if(!isset(self::$medicinesScName))
            self::$medicinesScName = MedicinesScName::where('is_active', 1)->withTranslation()->latest()->get();
        return self::$medicinesScName;

    }
    public function getScientificName()
    {
        if(!isset(self::$sc_companies))
            self::$sc_companies = MedicinesScName::where('is_active', 1)->withTranslation()->latest()->get();

        return self::$sc_companies;
    }

    public function getGender()
    {
        return [
          'male' => 'male',
          'female' => 'female'
        ];
    }

    public function userTypes()
    {
        return \App\Models\User::USER_TYPE;
    }

    public function getRoles()
    {
        return Role::get();
    }

    public static function weekDays(){
        return [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday'
        ];
    }


}
