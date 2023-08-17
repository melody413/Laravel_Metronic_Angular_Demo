<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Hospital;
use App\Models\InsuranceCompany;
use App\Models\Lab;
use App\Models\Pharmacy;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Corcel\Model\Post;

class HomeController extends BaseController
{
    public function init(Request $request)
    {
        $vars = [
            'doctorSearch'=> [
                'route' => route('frontend.doctor.index'),
                'speciality',
                'city',
                'area',
                'insurance',
                'name'
            ],'labSearch'=> [
                'route' => route('frontend.lab.index'),
                'city',
                'area',
                'labServices',
                'insurance',
                'name'
            ],'hospitalSearch'=> [
                'route' => route('frontend.hospital.index'),
                'speciality',
                'city',
                'area',
                'insurance',
                'name'
            ],'centerSearch'=> [
                'route' => route('frontend.center.index'),
                'city',
                'area',
                'insurance',
                'name'
            ],'pharmacySearch'=> [
                'route' => route('frontend.pharmacy.index'),
                'city',
                'area',
                'insurance',
                'name'
            ],'insuranceSearch'=> [
                'route' => route('frontend.insurance_company.index'),
                'city',
                'area',
                'insurance',
                'name'
            ],'medicineSearch'=> [
                'route' => route('frontend.medicine.index'),
                'scientific_name',
                'company',
                'form',
                'name'
            ],
        ];

        $city = $request->input('city',0);
        if($city)
        {
            $vars['areas'] = dataForm()->getAreas($city);
        }

        view()->share(['homeParams' => $vars]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if($request->getPathInfo() == "/medicines")
        //     return \Redirect::route('frontend.medicine.index');

        $doctors_specialites = $request->session()->get('doctors_specialites');
        if (!$doctors_specialites) {
            $doctors_specialites = Specialty::getIsActive()->take(10)->get();
            $request->session()->put('doctors_specialites',$doctors_specialites);
        }
        $hospitals = $request->session()->get('hospitals');
        if (!$hospitals) {
            $hospitals = Hospital::getIsActive()->take(10)->get();
            $request->session()->put('hospitals',$hospitals);
        }
        $pharmacies = $request->session()->get('pharmacies');
        if (!$pharmacies) {
            $pharmacies = Pharmacy::getIsActive()->take(10)->get();
            $request->session()->put('pharmacies',$pharmacies);
        }
        $labs = $request->session()->get('labs');
        if (!$labs) {
            $labs = Lab::getIsActive()->take(10)->get();
            $request->session()->put('labs',$labs);
        }
        $centers = $request->session()->get('centers');
        if (!$centers) {
            $centers = Center::getIsActive()->take(10)->get();
            $request->session()->put('centers',$centers);
        }
        $blog_posts = null; //Post::published()->newest()->take(10)->get(); // OR
        // if($_SERVER["REMOTE_ADDR"]=='172.68.133.140')
        //     dd($blog_posts->first());
        // Blog Posts API Retreve
        // $url ='https://doctorak.com/blog/wp-json/wp/v2/posts?per_page=9&page=1';
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // // //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  0);
        //  $json = curl_exec($ch);
        // $blog_posts = json_decode($json);
        // $blog_posts = [];
        // $posts = App\Post::all(); // using the 'foo-bar' connection


        return view($this->getTemplatePath('index'),compact('doctors_specialites','hospitals', 'pharmacies', 'labs', 'blog_posts', 'centers'));
    }

    public function home(Request $request)
    {
        return redirect('/');
    }

    protected function getTemplateFolder()
    {
        return 'home';
    }
}
