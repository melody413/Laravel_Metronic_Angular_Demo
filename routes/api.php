<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['namespace' => 'Api', 'prefix' => env('API_PREFIX')], function () {
    Route::post('/login', 'AuthController@login')->name('login');
    Route::post('/loginout', 'AuthController@logout')->name('loginout');

    //dashboard API
    Route::get('/dashboard', 'ADashboardController@home')->name('dashboard');

    //bodypart API
    Route::get('/bodypart/list', 'ABodypartController@index')->name('bodypart');
    Route::post('/bodypart/store', 'ABodypartController@store');
    Route::get('/bodypart/create', 'ABodypartController@create');
    Route::get('/bodypart/delete/{id}', 'ABodypartController@delete');
    Route::get('/bodypart/edit/{id}',  'ABodypartController@edit');
    Route::get('/body_part/copy/{id}',  'ABodypartController@copy');

    //Disease API
    Route::get('/disease/list', 'ADiseaseController@index')->name('disease');
    Route::get('/disease/create', 'ADiseaseController@create' );
    Route::get('/disease/edit/{id}', 'ADiseaseController@edit');
    Route::get('/disease/delete/{id}', 'ADiseaseController@delete' );
    Route::get('/disease/copy/{id}', 'ADiseaseController@copy' );
    Route::post('/disease/store', 'ADiseaseController@store' );

    //Doctor API
    Route::get('/doctor/list', 'ADoctorController@index')->name('Adoctor');
    Route::get('/doctor/create', 'ADoctorController@create' );
    Route::get('/doctor/edit/{id}', 'ADoctorController@edit' );
    Route::get('/doctor/delete/{id}', 'ADoctorController@delete' );
    Route::post('/doctor/store', 'ADoctorController@store' );

    //Reservation API
    Route::get('/reservation/list', 'AReservationController@index')->name('reservation');  
    Route::get('/reservation/edit/{id}','AReservationController@edit' );
    Route::post('/reservation/store', 'AReservationController@store');
    Route::get('/reservation/delete/{id}', 'AReservationController@delete' );
    Route::get('/reservation/view/{id}', 'AReservationController@view' );

    //Pharmacy API
    Route::get('/pharmacy/list', 'APharmacyController@index')->name('pharmecy');
    Route::get('/pharmacy/create', 'APharmacyController@create');
    Route::get('/pharmacy/edit/{id}', 'APharmacyController@edit' );
    Route::get('/pharmacy/delete/{id}', 'APharmacyController@delete' );
    Route::get('/pharmacy/copy/{id}', 'APharmacyController@copy' );
    Route::post('/pharmacy/store', 'APharmacyController@store' );

    //Pharemacy company API
    Route::get('/pharmacy_company/list', 'APharmacyCompanyController@index');
    Route::get('/pharmacy_company/create', 'APharmacyCompanyController@create' );
    Route::get('/pharmacy_company/edit/{id}', 'APharmacyCompanyController@edit' );
    Route::get('/pharmacy_company/delete/{id}', 'APharmacyCompanyController@delete' );
    Route::get('/pharmacy_company/copy/{id}', 'APharmacyCompanyController@copy' );
    Route::post('/pharmacy_company/store', 'APharmacyCompanyController@store' );

    //
    Route::get('/lab_services/list', 'ALabServiceController@index');
    Route::get('/lab_services/create', 'ALabServiceController@create' );
    Route::get('/lab_services/edit/{id}', 'ALabServiceController@edit' );
    Route::get('/lab_services/delete/{id}', 'ALabServiceController@delete');
    Route::get('/lab_services/copy/{id}', 'ALabServiceController@copy' );
    Route::post('/lab_services/store', 'ALabServiceController@store' );

    //Lab API
    Route::get('/lab/list', 'ALabController@index');
    Route::get('/lab/create', 'ALabController@create' );
    Route::get('/lab/edit/{id}', 'ALabController@edit' );
    Route::get('/lab/delete/{id}', 'ALabController@delete' );
    Route::get('/lab/copy/{id}', 'ALabController@copy');
    Route::post('/lab/store', 'ALabController@store' );

    //Lab company API
    Route::get('/lab_company/list', 'ALabCompanyController@index');
    Route::get('/lab_company/create', 'ALabCompanyController@create' );
    Route::get('/lab_company/edit/{id}', 'ALabCompanyController@edit' );
    Route::get('/lab_company/delete/{id}', 'ALabCompanyController@delete' );
    Route::get('/lab_company/copy/{id}', 'ALabCompanyController@copy' );
    Route::post('/lab_company/store', 'ALabCompanyController@store' );
    

    //Lab category API
    Route::get('/lab_category/list', 'ALabCategoryController@index');
    Route::get('/lab_category/create', 'ALabCategoryController@create' );
    Route::get('/lab_category/edit/{id}','ALabCategoryController@edit' );
    Route::get('/lab_category/delete/{id}', 'ALabCategoryController@delete' );
    Route::get('/lab_category/copy/{id}', 'ALabCategoryController@copy' );
    Route::post('/lab_category/store', 'ALabCategoryController@store' );

    //insurance API
    Route::get('/insurance_company/list', 'AInsuranceCompanyController@index');
    Route::get('/insurance_company/create',  'AInsuranceCompanyController@create' );
    Route::get('/insurance_company/edit/{id}','AInsuranceCompanyController@edit');
    Route::get('/insurance_company/delete/{id}','AInsuranceCompanyController@delete' );
    Route::get('/insurance_company/copy/{id}', 'AInsuranceCompanyController@copy' );
    Route::post('/insurance_company/store', 'AInsuranceCompanyController@store' );

    //Hospital API
    Route::get('/hospital/list', 'AHospitalController@index');
    Route::get('/hospital/create', 'AHospitalController@create');
    Route::get('/hospital/edit/{id}', 'AHospitalController@edit' );
    Route::get('/hospital/delete/{id}','AHospitalController@delete');
    Route::get('/hospital/copy/{id}', 'AHospitalController@copy' );
    Route::post('/hospital/store', 'AHospitalController@store');

    //Hospital type API
    Route::get('/hospital_type/list', 'AHospitalTypeController@index');
    Route::get('/hospital_type/create', 'AHospitalTypeController@create' );
    Route::get('/hospital_type/edit/{id}', 'AHospitalTypeController@edit' );
    Route::get('/hospital_type/delete/{id}', 'AHospitalTypeController@delete' );
    Route::get('/hospital_type/copy/{id}', 'AHospitalTypeController@copy' );
    Route::post('/hospital_type/store', 'AHospitalTypeController@store' );

    //Center API
    Route::get('/center/list', 'ACenterController@index');
    Route::get('/center/create', 'ACenterController@create' );
    Route::get('/center/edit/{id}', 'ACenterController@edit');
    Route::get('/center/delete/{id}', 'ACenterController@delete' );
    Route::get('/center/copy/{id}', 'ACenterController@copy' );
    Route::post('/center/store', 'ACenterController@store');
    
    //Symptom API
    Route::get('/symptom/list', 'ASymptomController@index');
    Route::get('/symptom/create', 'ASymptomController@create' );
    Route::get('/symptom/edit/{id}', 'ASymptomController@edit');
    Route::get('/symptom/delete/{id}','ASymptomController@delete');
    Route::get('/symptom/copy/{id}','ASymptomController@copy' );
    Route::post('/symptom/store', 'ASymptomController@store');

});