<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 'HomeController@welcome');
Route::get('/', function () {
    return redirect('/login');
});
//Website
Route::get('/appointment','WebSiteController@appointment');

Route::get('/access-denied', 'HomeController@accessDenied');
Route::get('/account-disabled','HomeController@accountDisable');

// Cache config
Route::get('/config-cache','SettingController@cacheConfig');
Route::get('/cache-config-success','SettingController@cacheConfigSuccess');

// Install
Route::get('/install','HomeController@install');
Route::get('/install-success','SettingController@installSuccess');
Route::post('/save-mysql','SettingController@postMySQLSetting');

Auth::routes();

Route::middleware(['auth','active.user'])->group(function (){
    Route::get('/home', 'HomeController@index')->name('home');
    // Profile
    Route::get('/profile','SettingController@profileSetting');
    Route::get('/edit-profile','UserController@editProfile');
    Route::post('/update-profile','UserController@updateProfile');
    Route::post('/change-password','SettingController@changePassword');

    Route::middleware('assistant')->group(function (){
        //Appointment
        Route::get('/take-patient-to-appointment/{patient_id}','AppointmentController@takePatientToAppointment');
        Route::get('/new-appointment','AppointmentController@newAppointment');
        Route::get('/all-appointment','AppointmentController@allAppointment');
        Route::get('/edit-appointment/{id}','AppointmentController@editAppointment');
        Route::get('/delete-appointment/{id}','AppointmentController@deleteAppointment');
        Route::post('/save-appointment','AppointmentController@saveAppointment');
        Route::post('/update-appointment/{id}','AppointmentController@updateAppointment');
        // Appointment Today
        Route::get('/appointment-today','AppointmentController@appointmentToday');

        // Patient Management
        Route::get('/new-patient', 'PatientController@newPatient');
        Route::get('/all-patient', 'PatientController@allPatient');
        Route::get('/view-patient/{id}','PatientController@viewPatient');
        Route::get('/edit-patient/{id}', 'PatientController@editPatient');
        Route::get('/patient-medical-file/{id}','PatientController@patientMedicalFile');
        Route::get('/delete-medical-file/{id}','PatientController@deleteMedicalFile');
        Route::get('/patient-history/{id}','PatientController@patientMedicalHistory');
        Route::get('/delete-patient/{id}', 'PatientController@deletePatient');
        Route::post('/save-patient', 'PatientController@savePatient');
        Route::post('/save-medical-file/{patient_id}','PatientController@saveMedicalFile');
        Route::post('/update-patient/{id}', 'PatientController@updatePatient');
    });

    Route::middleware(['doctor'])->group(function (){
        //Prescription Helper - Drug Type
        Route::get('/delete-drug-type/{id}', 'PrescriptionHelperController@deleteDrugType');
        Route::post('/save-drug-type', 'PrescriptionHelperController@saveDrugType');
        Route::post('/update-drug-type/{id}', 'PrescriptionHelperController@updateDrugType');

        //Prescription Helper - Drug Strength
        Route::get('/delete-drug-strength/{id}', 'PrescriptionHelperController@deleteDrugStrength');
        Route::post('/save-drug-strength', 'PrescriptionHelperController@saveDrugStrength');
        Route::post('/update-drug-strength/{id}', 'PrescriptionHelperController@updateDrugStrength');

        //Prescription Helper - Drug Dose
        Route::get('/delete-drug-dose/{id}', 'PrescriptionHelperController@deleteDrugDose');
        Route::post('/save-drug-dose', 'PrescriptionHelperController@saveDrugDose');
        Route::post('/update-drug-dose/{id}', 'PrescriptionHelperController@updateDrugDose');

        //Prescription Helper - Drug Duration
        Route::get('/delete-drug-duration/{id}', 'PrescriptionHelperController@deleteDrugDuration');
        Route::post('/save-drug-duration', 'PrescriptionHelperController@saveDrugDuration');
        Route::post('/update-drug-duration/{id}', 'PrescriptionHelperController@updateDrugDuration');

        //Prescription Helper - Drug Advice
        Route::get('/delete-drug-advice/{id}', 'PrescriptionHelperController@deleteDrugAdvice');
        Route::post('/save-drug-advice', 'PrescriptionHelperController@saveDrugAdvice');
        Route::post('/update-drug-advice/{id}', 'PrescriptionHelperController@updateDrugAdvice');

        // Drug management
        Route::get('/new-drug', 'DrugController@newDrug');
        Route::get('/all-drug', 'DrugController@allDrug');
        Route::get('/edit-drug/{id}', 'DrugController@editDrug');
        Route::get('/delete-drug/{id}', 'DrugController@deleteDrug');
        Route::post('/save-drug', 'DrugController@saveDrug');
        Route::post('/save-new-drug','DrugController@saveNewDrug');
        Route::post('/update-drug/{id}', 'DrugController@updateDrug');

        // Advice Management
        Route::get('/delete-advice/{id}', 'AdviceController@deleteAdvice');
        Route::post('/save-advice', 'AdviceController@saveAdvice');
        Route::post('/update-advice/{id}', 'AdviceController@updateAdvice');



        // Prescription Template Management
        Route::get('/new-template', 'TemplateController@newTemplate');
        Route::get('/all-template', 'TemplateController@allTemplate');
        Route::get('/edit-template/{id}', 'TemplateController@editTemplate');
        Route::get('/view-template/{id}','TemplateController@viewTemplate');
        Route::get('/delete-template/{id}', 'TemplateController@deleteTemplate');
        Route::post('/save-template', 'TemplateController@saveTemplate');
        Route::post('/update-template/{id}', 'TemplateController@updateTemplate');

        // Prescription Management
        Route::get('/take-patient-to-prescription-page/{patient_id}','PrescriptionController@takePatientToPrescription');
        Route::get('/new-prescription', 'PrescriptionController@newPrescription');
        Route::get('/all-prescription', 'PrescriptionController@allPrescription');
        Route::get('/print-prescription/{id}','PrescriptionController@printPrescription');
        Route::get('/delete-prescription/{id}', 'PrescriptionController@deletePrescription');
        Route::post('/save-prescription', 'PrescriptionController@savePrescription');

        // Assistant Management
        Route::get('/new-assistant', 'UserController@newAssistant');
        Route::get('/edit-assistant/{id}', 'UserController@editAssistant');
        Route::get('/all-assistant','UserController@allAssistant');
        Route::get('/delete-assistant/{id}', 'UserController@deleteAssistant');
        Route::post('/save-assistant', 'UserController@saveAssistant');
        Route::post('/update-assistant/{id}', 'UserController@updateAssistant');
        
        // Schedule
        Route::get('/new-schedule','ScheduleController@newSchedule');
        Route::get('/all-schedule','ScheduleController@allSchedule');
        Route::get('/edit-schedule/{id}','ScheduleController@editSchedule');
        Route::get('/delete-schedule/{id}','ScheduleController@deleteSchedule');
        Route::post('/save-schedule','ScheduleController@saveSchedule');
        Route::post('/update-schedule/{id}','ScheduleController@updateSchedule');

        Route::get('/schedule={id}/date-time','ScheduleController@scheduleDateTime');
        Route::post('/save-schedule-datetime/{schedule_id}','ScheduleController@saveScheduleDateTime');
        Route::get('/delete-schedule-datetime/{id}','ScheduleController@deleteScheduleDateTime');

        // App Setting
        Route::get('/app-setting','SettingController@appSetting');
        Route::get('/prescription-setting','SettingController@prescriptionSetting');
        Route::post('/mail-setting','SettingController@postMailSetting');
        Route::post('/app-setting','SettingController@appSetup');
        Route::post('/prescription-print-setting','SettingController@postPrescriptionPrintSetting');

        // Save about
        Route::post('/save-about','WebSiteController@saveAboutMe');

        // Reports
        Route::get('/drug-report/drug={id}/start={start_date}/end={end_date}','DrugController@drugReport');
        Route::get('/template-report/template={id}/start={start_date}/end={end_date}','TemplateController@templateReport');
        Route::get('/schedule-report/schedule={id}/start={start_date}/end={end_date}','ScheduleController@scheduleReport');
    });


});

