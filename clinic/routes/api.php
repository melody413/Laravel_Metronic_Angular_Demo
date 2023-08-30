<?php

use Illuminate\Http\Request;

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

// Dashboard Apis
Route::get('/latest-prescription','DashboardController@latestPrescription');
Route::get('/latest-appointment','DashboardController@latestAppointment');
Route::get('/latest-patient','DashboardController@lastSevenDaysPatient');
Route::get('/todays-patient','DashboardController@todaysPatient');
Route::get('/total-patient','DashboardController@totalPatient');

Route::get('/template-details/{id}','PrescriptionApiController@getTemplateDetails');
Route::get('/prescription-details/{id}','PrescriptionApiController@getPrescriptionDetails');
Route::get('/patient-details/{id}','PrescriptionApiController@getPatientDetails');

Route::get('/get-schedule-details/{id}','ApiController@getScheduleDetails');

// Prescription Helper Setting
Route::get('/get-drug-type-details/{id}','PrescriptionHelperController@getDrugTypeDetails');
Route::get('/get-drug-strength-details/{id}','PrescriptionHelperController@getDrugStrengthDetails');
Route::get('/get-drug-dose-details/{id}','PrescriptionHelperController@getDrugDoseDetails');
Route::get('/get-drug-duration-details/{id}','PrescriptionHelperController@getDrugDurationDetails');
Route::get('/get-drug-advice-details/{id}','PrescriptionHelperController@getDrugAdviceDetails');
Route::get('/get-advice-details/{id}','AdviceController@getAdviceDetails');

Route::get('/data-table/all-drug','ApiController@allDrugToDataTable')->name('drug.datatable');
Route::get('/data-table/all-assistant','ApiController@allAssistantToDataTable')->name('assistant.datatable');
Route::get('/data-table/all-template/{id}','ApiController@allTemplateToDataTable')->name('template.datatable');
Route::get('/data-table/all-prescription/{id}','ApiController@allPrescriptionToDataTable');
Route::get('/data-table/all-patient','ApiController@allPatientToDataTable');
Route::get('/data-table/my-schedule','ApiController@myScheduleToDataTable');
Route::get('/data-table/all-appointment','ApiController@allAppointmentToDataTable');
Route::get('/data-table/appointment-today','ApiController@appointmentToday');
Route::get('/data-table/all-drug-types','ApiController@allDrugTypesToDataTable');
Route::get('/data-table/all-drug-strength','ApiController@allDrugStrengthToDataTable');
Route::get('/data-table/all-drug-dose','ApiController@allDrugDosesToDataTable');
Route::get('/data-table/all-drug-duration','ApiController@allDrugDurationToDataTable');
Route::get('/data-table/all-drug-advice','ApiController@allDrugAdviceToDataTable');
Route::get('/data-table/all-advice','ApiController@allAdviceToDataTable');

// Api for prescription
Route::get('/get-drug-types','PrescriptionApiController@getDrugTypes');
Route::get('/get-drug-strengths','PrescriptionApiController@getDrugStrength');
Route::get('/get-drug-doses','PrescriptionApiController@getDrugDose');
Route::get('/get-drug-durations','PrescriptionApiController@getDrugDuration');
Route::get('/get-drug-advices','PrescriptionApiController@getDrugAdvice');
Route::get('/get-advices','PrescriptionApiController@getAdvice');