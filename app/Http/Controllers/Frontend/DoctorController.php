<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Area;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Qanswer;
use App\Models\QanswerSpecialty;
use App\Models\DoctorBranch;
use App\Models\DoctorRating;
use App\Models\DoctorReservation;
use App\Models\Pharmacy;
use App\Models\Specialty;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class DoctorController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'route' => route('frontend.doctor.index'),
            'speciality',
            'city',
            'area',
            'insurance',
            'name'
        ];

        $city = $request->input('city',0);
        if($city)
        {
            $vars['areas'] = dataForm()->getAreas($city);
        }

        view()->share(['headerSearchParams' => $vars]);
    }

    public function index(Request $request)
    {
        $sub_cat = $request->input('sub_cat', null);

        $rows = searchManger()
            ->of(Doctor::getIsActive()->withTranslation())
            ->filterWithCity()
            ->filterWithArea()
            ->filterWithInsuranceCompany()
            ->filterWithName()
            ->filterWithGender()
            // ->filterWithSubCat()
            ->filterWithSpeciality()
            ->whereHas(
                'branches', function($q) use($request) {
                    $q->where('city_id', $request->input('city'));
                } , $request->input('city')
            )
            ->whereHas(
                'branches', function($q) use($request) {
                    $q->where('area_id', $request->input('area'));
                }, $request->input('area')
            )
            ->paginate();

        $Speciality = Specialty::where('id', $request->input('speciality', null))->withTranslation()->first();
        $city = City::where('id', $request->input('city', null) )->withTranslation()->first();
        $area = Area::where('id', $request->input('area', null) )->withTranslation()->first();
        $tag = Tag::where('id', $request->input('tag'))->withTranslation()->first();
        //  $tag = Tag::where('id', $request->input('tag')) ->withTranslation()->first();
        $sub_cats_arr = "";
        $sub_cats_arr2 = "";

        if(isset($Speciality)) {
            $sub_cats_arr = \App\Models\SpecialtySubCategory::where('specialty_id', $request->input('speciality', null))->take(10)->get();
            $sub_cats_arr2 = \App\Models\SpecialtySubCategory::where('specialty_id', $request->input('speciality', null))->orderBy('id', 'desc')->take(5)->get();
         //  $Speciality = \App\Models\SubCategory::where('id', $sub_cat)->first()->name;
        }
        // dd($sub_cats_arr);
        $page_title = getMainModuleTitle('doctors',$city,$area,$Speciality,$sub_cat);
        $qanswers_qanswer_ids = QanswerSpecialty::where('specialty_id', $request->input('speciality', null))->pluck("qanswer_id")->toArray();
        //dd($qanswers_qanswer_ids[0]);
        $qanswers_ar = \App\Models\QanswerTrans::whereIn('qanswer_id', $qanswers_qanswer_ids)->where('locale', 'ar')->get();

        return view($this->getTemplatePath('index'), compact('sub_cats_arr2', 'sub_cats_arr', 'rows', 'area', 'city', 'Speciality', 'page_title', 'tag', 'sub_cat', 'qanswers_qanswer_ids', 'qanswers_ar'));
    }

    public function unit($id)
    {
        $row = Doctor::with(['hospitals','ratings','ratings.user','insuranceCompanies','branches','area'])->where('is_active', 1)->where('id',$id)->first();

        if(!$row){
            return abort(404);

            throw(
            new \Exception('row not found')
            );
        }
        //dd($row->specialties()->pluck('specialty_id')[0]);
        $page_title = trans('general.dr') . ' ' . $row->name;
        //$specialty = Specialty::where('id', $row->specialties()->pluck('specialty_id')[0])->withTranslation();
        $tags = Tag::where('module_name', 'doctor')->get();
        $specialty = $row->specialties()->pluck('specialty_id');
        //$sub_cat = $request->input('sub_cat', null);

        view()->share(['doctor' => $row, 'page_title' => $page_title]);
        return view($this->getTemplatePath('unit'), compact(['row','specialty','tags']));
    }

    public function reserve(Request $request, $id)
    {
        $validator = $request->validate([
            'branch_id' => 'required|integer',
            'reserve_date' => 'required|date_format:d/m/Y H:i',
            'reserve_name' => 'required',
            'reserve_email' => 'required',
            'reserve_phone' => 'required',
        ]);
        $postData = $request->except('_token');

        $carbonDate = Carbon::createFromFormat('d/m/Y H:i',$postData['reserve_date']);

        //check if reserved
        $reservCh = DoctorReservation::where('reserve_time', $carbonDate->format('H:i'))
            ->where('reserve_date', $carbonDate->format('Y-m-d'))
            ->where('doctor_branch_id', $postData['branch_id'])
            ->first();

        $doctorDb = Doctor::where('id',$id)->withTranslation()->first();
        $doctorBranchDb = DoctorBranch::where('id',$postData['branch_id'])->withTranslation()->first();

        if( ( !$doctorDb && !$doctorBranchDb) || $reservCh)
            return redirect()->back();

        $reserveDb = new DoctorReservation();
        $reserveDb->name = $postData['reserve_name'];
        $reserveDb->email = $postData['reserve_email'];
        $reserveDb->phone = $postData['reserve_phone'];
        $reserveDb->doctor_id = $doctorDb->id;
        $reserveDb->doctor_branch_id = $doctorBranchDb->id;

        if (Auth::check())
            $reserveDb->user_id = Auth::user()->id;

        $reserveDb->reserve_time = $carbonDate->format('H:i');
        $reserveDb->reserve_date = $carbonDate->format('Y-m-d');

        $reserveDb->shortcut = json_encode([
            'doctor_name' => $doctorDb->name,
            'reservation_address_ar' => $doctorBranchDb->translations[0]->address,
            'country_name' => $doctorBranchDb->country->name,
            'city_name' => $doctorBranchDb->city->name,
            'area_name' => $doctorBranchDb->area->name,
        ]);

        $reserveDb->save();

        return redirect( route('frontend.doctor.reserveSuccess', ['id' => $reserveDb->id]) );
    }

    public function reserveSuccess(Request $request, $id)
    {
        $reserve = DoctorReservation::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ( ! $reserve )
            return redirect( route('frontend.home') );


        $doctorBranchDb = DoctorBranch::where('id',$reserve['doctor_branch_id'])->withTranslation()->first();

        $shortcut = json_decode($reserve->shortcut, true);


        return view($this->getTemplatePath('reserve_success'), ['reserve' => $reserve, 'shortcut'=> $shortcut, 'branch' => $doctorBranchDb]);
    }

    public function review(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'review_comment' => 'string|nullable',
            'review_value' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(!isset(Auth::user()->id))
            return redirect()->back();

        $doctor = Doctor::findOrFail($id);

        $rating = new DoctorRating();
        $rating->rate = $request->get('review_value');
        $rating->comment = $request->get('review_comment');
        $rating->doctor_id = $doctor->id;
        $rating->user_id = Auth::user()->id;
        $rating->save();

        $rates =  $doctor->ratings();
        $rate_count =  $rates->count();
        $rate_values = $rates->sum('rate');

        $doctor->rate = $rate_values / $rate_count;
        $doctor->rate_cnt = $rate_count;
        $doctor->save();

        return redirect()->back();

    }

    protected function getTemplateFolder()
    {
        return 'doctor';
    }
}
