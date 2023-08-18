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
    Route::get('/dashboard', 'ADashboardController@home')->name('dashboard');
    Route::get('/bodypart/list', 'ABodypartController@index')->name('bodypart');
    
    Route::post('/bodypart/store', 'ABodypartController@store');




    Route::get('/disease/list', 'ADiseaseController@index')->name('disease');
    Route::get('/doctor/list', 'ADoctorController@index')->name('Adoctor');
    Route::get('/reservation/list', 'AReservationController@index')->name('Adoctor');    
    Route::get('/pharmacy/list', 'APharmacyController@index')->name('pharmecy');
    Route::get('/pharmacy_company/list', 'APharmacyCompanyController@index');
    Route::get('/lab_services/list', 'ALabServiceController@index');
    Route::get('/lab/list', 'ALabController@index');
    Route::get('/lab_company/list', 'ALabCompanyController@index');
    Route::get('/lab_category/list', 'ALabCategoryController@index');
    Route::get('/insurance_company/list', 'AInsuranceCompanyController@index');
    Route::get('/hospital/list', 'AHospitalController@index');
    Route::get('/hospital_type/list', 'AHospitalTypeController@index');
    Route::get('/center/list', 'ACenterController@index');
    

});