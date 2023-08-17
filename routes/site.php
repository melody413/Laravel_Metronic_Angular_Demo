
<?php

use App\Http\Controllers\SendEmailController;

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
//Auth::routes();
$locale = Request::segment(1);

if ( in_array($locale, [env('ADMIN_PREFIX')]) )
    $locale = 'eg';

Route::get('/data/cities/{country_id}', 'Frontend\DataFormController@getCities')->name('dataForm.cities');
Route::get('/data/areas/{city_id}', 'Frontend\DataFormController@getAreas')->name('dataForm.areas');

// Route::get('/medicines', 'MedicineController@index')->name('frontend.medicine.index');
// Route::get('/medicine/{id}', 'MedicineController@unit')->name('frontend.medicine.unit');
// Route::get('/medicine_company/{id}', 'MedicineController@medicines_company')->name('frontend.medicines_company.index');
// Route::get('/medicine_sc_name/{id}', 'MedicineController@medicines_sc_name')->name('frontend.medicines_sc_name.index');


//dd($locale);
// if($locale == 'medicines'){
//     Route::get('/', 'MedicineController@index')->name('frontend.medicine.index');
//     // return Redirect::route('frontend.medicine.index');
// }
// Route::get('/medicines', 'MedicineController@index')->name('frontend.medicine.index');
    // return Redirect::route('frontend.medicine.index');
    // dd(Request::segment(1));

// $locale = 'eg';
// , 'middleware' => ['localize', 'localeSessionRedirect','localizationRedirect']
Route::group(['namespace' => 'Frontend', 'prefix' => $locale, 'middleware' => 'throttle:50,1'], function(){
    // dd($locale);
    Route::get('send-email','SendEmailController@sendEmail');
    Route::get('/reload-captcha', [App\Http\Controllers\Frontend\StaticPages::class, 'reloadCaptcha']);

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/', 'HomeController@index')->name('frontend.home');

    Route::get('/login', ['uses' => 'Auth\LoginController@showLogin' , 'as'=>'login'] );
    Route::post('/login', ['uses' => 'Auth\LoginController@login' , 'as'=>'frontend.user.post_login'] );
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout' , 'as'=>'frontend.user.logout'] );
    Route::get('/register', ['uses' => 'Auth\RegisterController@showRegistrationForm' , 'as'=>'frontend.user.register'] );
    Route::post('/register', ['uses' => 'Auth\RegisterController@register' , 'as'=>'frontend.user.post_register'] );

    Route::get('/forget-password', ['uses' => 'Auth\ForgotPasswordController@showLinkRequestForm' , 'as'=>'frontend.password.request'] );
    Route::post('/forget-password', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail' , 'as'=>'frontend.password.post_request'] );

    Route::post('/password-reset', ['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail' , 'as'=>'frontend.password.reset'] );


    Route::get('/profile', ['uses' => 'UserController@profile' , 'as'=>'frontend.user.profile'] )->middleware('auth');
    Route::post('/profile', ['uses' => 'UserController@storeProfile' , 'as'=>'frontend.user.post_profile'] )->middleware('auth');

    Route::get('/change-password', ['uses' => 'UserController@changePassword' , 'as'=>'frontend.user.change_password'] )->middleware('auth');
    Route::post('/change-password', ['uses' => 'UserController@storeNewPassword' , 'as'=>'frontend.user.post_change_password'] )->middleware('auth');

    Route::get('/data/cities/{country_id}', 'DataFormController@getCities')->name('dataForm.cities');
    Route::get('/data/areas/{city_id}', 'DataFormController@getAreas')->name('dataForm.areas');

    Route::get('/pharmacy', 'PharmacyController@index')->name('frontend.pharmacy.index');
    Route::get('/pharmacy/{id}', 'PharmacyController@unit')->name('frontend.pharmacy.unit');

    Route::get('/lab', 'LabController@index')->name('frontend.lab.index');
    Route::get('/lab/{id}', 'LabController@unit')->name('frontend.lab.unit');

    Route::get('/lab-service', 'LabServiceController@index')->name('frontend.lab_service.index');
    Route::get('/lab-service/{id}', 'LabServiceController@unit')->name('frontend.lab_service.unit');

    Route::get('/insurance-company', 'InsuranceCompanyController@index')->name('frontend.insurance_company.index');
    Route::get('/insurance-company/{id}', 'InsuranceCompanyController@unit')->name('frontend.insurance_company.unit');

    Route::get('/hospital', 'HospitalController@index')->name('frontend.hospital.index');
    Route::get('/hospital/{id}/address', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}/phone', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}/doctors', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}/doctors_names', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}/categories', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}/outpatient_clinics', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}/clinics', 'HospitalController@unit')->name('frontend.hospital.unit');
    Route::get('/hospital/{id}', 'HospitalController@unit')->name('frontend.hospital.unit');

    Route::get('/center', 'CenterController@index')->name('frontend.center.index');
    Route::get('/center/{id}/address', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}/phone', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}/doctors', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}/doctors_names', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}/categories', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}/outpatient_clinics', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}/clinics', 'CenterController@unit')->name('frontend.center.unit');
    Route::get('/center/{id}', 'CenterController@unit')->name('frontend.center.unit');

    Route::get('/tag', 'TagController@index')->name('frontend.tag.index');
    Route::get('/tag/{id}', 'TagController@unit')->name('frontend.tag.unit');

    Route::get('/sub_category', 'SubCategoryController@index')->name('frontend.sub_category.index');
    Route::get('/sub_category/{id}', 'SubCategoryController@unit')->name('frontend.sub_category.unit');

    Route::get('/my-reservation', 'UserController@reservation')->name('frontend.my.reservation');
    Route::get('/doctor-reservation', 'UserController@doctorReservations')->name('frontend.doctor.reservation');

    Route::get('/doctor', 'DoctorController@index')->name('frontend.doctor.index');
    Route::get('/doctor/{id}/address', 'DoctorController@unit')->name('frontend.doctor.unit');
    Route::get('/doctor/{id}/phone', 'DoctorController@unit')->name('frontend.doctor.unit');
    Route::get('/doctor/{id}', 'DoctorController@unit')->name('frontend.doctor.unit');
    Route::post('/doctor/{id}/review', 'DoctorController@review')->name('frontend.doctor.review');
    Route::post('/doctor/{id}/reserve', 'DoctorController@reserve')->name('frontend.doctor.reserve');
    Route::get('/doctor/{id}/reserve-success', 'DoctorController@reserveSuccess')->name('frontend.doctor.reserveSuccess');

    Route::get('/terms-and-conditions', 'StaticPages@termsAndConditions')->name('frontend.staticPages.termsAndConditions');
    Route::get('/contact-us', 'StaticPages@contactUs')->name('frontend.staticPages.contactUs');
    Route::post('/sendEmail', 'StaticPages@sendEmail')->name('frontend.staticPages.sendEmail');
    Route::get('/calc/{type}', 'StaticPages@calc')->name('frontend.staticPages.calc');
    Route::get('/home/{type}', 'StaticPages@calc')->name('frontend.staticPages.calc');

    Route::get('/medicinesForClinic', 'MedicineController@indexForClinic')->name('frontend.medicine.unit');
    Route::get('/medicines', 'MedicineController@index')->name('frontend.medicine.index');
    Route::get('/medicine/{id}', 'MedicineController@unit')->name('frontend.medicine.unit');
    Route::get('/medicine_company/{id}', 'MedicineController@medicines_company')->name('frontend.medicines_company.index');
    Route::get('/medicine_sc_name/{id}', 'MedicineController@medicines_sc_name')->name('frontend.medicines_sc_name.index');

    Route::get('/body-parts', 'BodyPartController@index')->name('frontend.body_part.index');
    Route::get('/body-part/{id}', 'BodyPartController@unit')->name('frontend.body_part.unit');

    Route::get('/qa', 'StaticPages@tickets')->name('frontend.staticPages.tickets');
});

