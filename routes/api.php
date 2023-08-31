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
    //In role page 
    Route::get('/permission-config', function () {
        return response()->json(config('permission'));
    });
    //dashboard API
    Route::get('/dashboard', 'ADashboardController@home')->name('dashboard');

    //bodypart API
    Route::get('/bodypart/list', 'ABodypartController@index')->name('bodypart');
    Route::post('/bodypart/store', 'ABodypartController@store');
    Route::get('/bodypart/create', 'ABodypartController@create');
    Route::get('/bodypart/delete/{id}', 'ABodypartController@delete');
    Route::get('/bodypart/edit/{id}',  'ABodypartController@edit');
    Route::get('/body_part/copy/{id}',  'ABodypartController@copy');
    Route::post('/bodypart/table', 'ABodypartController@table');

    //Disease API
    Route::get('/disease/list', 'ADiseaseController@index')->name('disease');
    Route::get('/disease/create', 'ADiseaseController@create' );
    Route::get('/disease/edit/{id}', 'ADiseaseController@edit');
    Route::get('/disease/delete/{id}', 'ADiseaseController@delete' );
    Route::get('/disease/copy/{id}', 'ADiseaseController@copy' );
    Route::post('/disease/store', 'ADiseaseController@store' );
    Route::post('/disease/table', 'ADiseaseController@table');

    //Doctor API
    Route::get('/doctor/list', 'ADoctorController@index')->name('Adoctor');
    Route::get('/doctor/create', 'ADoctorController@create' );
    Route::get('/doctor/edit/{id}', 'ADoctorController@edit' );
    Route::get('/doctor/delete/{id}', 'ADoctorController@delete' );
    Route::post('/doctor/store', 'ADoctorController@store' );
    Route::post('/doctor/table', 'ADoctorController@table');

    //Doctor branch API
    Route::get('/doctor/branch/{id}', 'ADoctorBranchController@index' );
    Route::get('/doctor/branch/create/{id}', 'ADoctorBranchController@create');
    Route::get('/doctor/branch/edit/{id}', 'ADoctorBranchController@edit' );
    Route::post('/doctor/branch/store','ADoctorBranchController@store' );
    Route::get('/doctor/branch/delete/{id}', 'ADoctorBranchController@delete');
    Route::get('/doctor/branch/toggleActive/{id}', 'ADoctorBranchController@toggleActive');

    //Doctor Rate API
    Route::get('/doctor/rate/{id}', 'ADoctorRateController@index' );
    Route::get('/doctor/rate/delete/{id}', 'ADoctorRateController@delete' );
    Route::get('/doctor/rate/toggleActive/{id}',  'ADoctorRateController@toggleActive' );

    //Reservation API
    Route::get('/reservation/list', 'AReservationController@index')->name('reservation');  
    Route::get('/reservation/edit/{id}','AReservationController@edit' );
    Route::post('/reservation/store', 'AReservationController@store');
    Route::get('/reservation/delete/{id}', 'AReservationController@delete' );
    Route::get('/reservation/view/{id}', 'AReservationController@view' );
    Route::post('/reservation/table', 'AReservationController@table');

    //Pharmacy API
    Route::get('/pharmacy/list', 'APharmacyController@index')->name('pharmecy');
    Route::get('/pharmacy/create', 'APharmacyController@create');
    Route::get('/pharmacy/edit/{id}', 'APharmacyController@edit' );
    Route::get('/pharmacy/delete/{id}', 'APharmacyController@delete' );
    Route::get('/pharmacy/copy/{id}', 'APharmacyController@copy' );
    Route::post('/pharmacy/store', 'APharmacyController@store' );
    Route::post('/pharmacy/table', 'APharmacyController@table');

    //Pharemacy company API
    Route::get('/pharmacy_company/list', 'APharmacyCompanyController@index');
    Route::get('/pharmacy_company/create', 'APharmacyCompanyController@create' );
    Route::get('/pharmacy_company/edit/{id}', 'APharmacyCompanyController@edit' );
    Route::get('/pharmacy_company/delete/{id}', 'APharmacyCompanyController@delete' );
    Route::get('/pharmacy_company/copy/{id}', 'APharmacyCompanyController@copy' );
    Route::post('/pharmacy_company/store', 'APharmacyCompanyController@store' );
    Route::post('/pharmacy_company/table', 'APharmacyCompanyController@table');

    //Lab Service API
    Route::get('/lab_services/list', 'ALabServiceController@index');
    Route::get('/lab_services/create', 'ALabServiceController@create' );
    Route::get('/lab_services/edit/{id}', 'ALabServiceController@edit' );
    Route::get('/lab_services/delete/{id}', 'ALabServiceController@delete');
    Route::get('/lab_services/copy/{id}', 'ALabServiceController@copy' );
    Route::post('/lab_services/store', 'ALabServiceController@store' );
    Route::post('/lab_services/table', 'ALabServiceController@table');

    //Lab API
    Route::get('/lab/list', 'ALabController@index');
    Route::get('/lab/create', 'ALabController@create' );
    Route::get('/lab/edit/{id}', 'ALabController@edit' );
    Route::get('/lab/delete/{id}', 'ALabController@delete' );
    Route::get('/lab/copy/{id}', 'ALabController@copy');
    Route::post('/lab/store', 'ALabController@store' );
    Route::post('/lab/table', 'ALabController@table');

    //Lab company API
    Route::get('/lab_company/list', 'ALabCompanyController@index');
    Route::get('/lab_company/create', 'ALabCompanyController@create' );
    Route::get('/lab_company/edit/{id}', 'ALabCompanyController@edit' );
    Route::get('/lab_company/delete/{id}', 'ALabCompanyController@delete' );
    Route::get('/lab_company/copy/{id}', 'ALabCompanyController@copy' );
    Route::post('/lab_company/store', 'ALabCompanyController@store' );
    Route::post('/lab_company/table', 'ALabCompanyController@table');


    //Lab category API
    Route::get('/lab_category/list', 'ALabCategoryController@index');
    Route::get('/lab_category/create', 'ALabCategoryController@create' );
    Route::get('/lab_category/edit/{id}','ALabCategoryController@edit' );
    Route::get('/lab_category/delete/{id}', 'ALabCategoryController@delete' );
    Route::get('/lab_category/copy/{id}', 'ALabCategoryController@copy' );
    Route::post('/lab_category/store', 'ALabCategoryController@store' );
    Route::post('/lab_category/table', 'ALabCategoryController@table');

    //insurance API
    Route::get('/insurance_company/list', 'AInsuranceCompanyController@index');
    Route::get('/insurance_company/create',  'AInsuranceCompanyController@create' );
    Route::get('/insurance_company/edit/{id}','AInsuranceCompanyController@edit');
    Route::get('/insurance_company/delete/{id}','AInsuranceCompanyController@delete' );
    Route::get('/insurance_company/copy/{id}', 'AInsuranceCompanyController@copy' );
    Route::post('/insurance_company/store', 'AInsuranceCompanyController@store' );
    Route::post('/insurance_company/table', 'AInsuranceCompanyController@table');

    //Hospital API
    Route::get('/hospital/list', 'AHospitalController@index');
    Route::get('/hospital/create', 'AHospitalController@create');
    Route::get('/hospital/edit/{id}', 'AHospitalController@edit' );
    Route::get('/hospital/delete/{id}','AHospitalController@delete');
    Route::get('/hospital/copy/{id}', 'AHospitalController@copy' );
    Route::post('/hospital/store', 'AHospitalController@store');
    Route::post('/hospital/table', 'AHospitalController@table');

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
    Route::post('/center/table', 'ACenterController@table');

    //Symptom API
    Route::get('/symptom/list', 'ASymptomController@index');
    Route::get('/symptom/create', 'ASymptomController@create' );
    Route::get('/symptom/edit/{id}', 'ASymptomController@edit');
    Route::get('/symptom/delete/{id}','ASymptomController@delete');
    Route::get('/symptom/copy/{id}','ASymptomController@copy' );
    Route::post('/symptom/store', 'ASymptomController@store');
    Route::post('/symptom/table', 'ASymptomController@table');

    Route::get('/medicines/list', 'AMedicineController@index' );
    Route::get('/medicines/create', 'AMedicineController@create' );
    Route::get('/medicines/edit/{id}', 'AMedicineController@edit');
    Route::get('/medicines/delete/{id}', 'AMedicineController@delete' );
    Route::get('/medicines/copy/{id}', 'AMedicineController@copy'  );
    Route::post('/medicines/store', 'AMedicineController@store'  );
    Route::post('/medicines/table', 'AMedicineController@table');

    Route::get('/medicines_company/list', 'AMedicinesCompanyController@index' );
    Route::get('/medicines_company/create', 'AMedicinesCompanyController@create' );
    Route::get('/medicines_company/edit/{id}','AMedicinesCompanyController@edit');
    Route::get('/medicines_company/delete/{id}', 'AMedicinesCompanyController@delete' );
    Route::get('/medicines_company/copy/{id}', 'AMedicinesCompanyController@copy' );
    Route::post('/medicines_company/store', 'AMedicinesCompanyController@store' );
    Route::post('/medicines_company/table', 'AMedicinesCompanyController@table');

    Route::get('/medicines_category/list', 'AMedicinesCategoryController@index');
    Route::get('/medicines_category/create', 'AMedicinesCategoryController@create');
    Route::get('/medicines_category/edit/{id}','AMedicinesCategoryController@edit');
    Route::get('/medicines_category/delete/{id}','AMedicinesCategoryController@delete');
    Route::get('/medicines_category/copy/{id}', 'AMedicinesCategoryController@copy' );
    Route::post('/medicines_category/store', 'AMedicinesCategoryController@store');
    Route::post('/medicines_category/table', 'AMedicinesCategoryController@table');

    Route::get('/medicines_sc_name/list', 'AMedicinesScNamesController@index');
    Route::get('/medicines_sc_name/create', 'AMedicinesScNamesController@create');
    Route::get('/medicines_sc_name/edit/{id}','AMedicinesScNamesController@edit' );
    Route::get('/medicines_sc_name/delete/{id}','AMedicinesScNamesController@delete');
    Route::get('/medicines_sc_name/copy/{id}', 'AMedicinesScNamesController@copy');
    Route::post('/medicines_sc_name/store', 'AMedicinesScNamesController@store');
    Route::post('/medicines_sc_name/table', 'AMedicinesScNamesController@table');

    //Tag API
    Route::get('/tag/list', 'ATagController@index');
    Route::get('/tag/create', 'ATagController@create');
    Route::get('/tag/edit/{id}', 'ATagController@edit');
    Route::get('/tag/delete/{id}', 'ATagController@delete');
    Route::get('/tag/copy/{id}', 'ATagController@copy');
    Route::post('/tag/store', 'ATagController@store');
    Route::post('/tag/table', 'ATagController@table');

    //sub_category API
    Route::get('/sub_category/list', 'ASubCategoryController@index');
    Route::get('/sub_category/create', 'ASubCategoryController@create' );
    Route::get('/sub_category/edit/{id}', 'ASubCategoryController@edit');
    Route::get('/sub_category/delete/{id}', 'ASubCategoryController@delete' );
    Route::get('/sub_category/copy/{id}','ASubCategoryController@copy');
    Route::post('/sub_category/store', 'ASubCategoryController@store');
    Route::post('/sub_category/table', 'ASubCategoryController@table');

    //question & answer API
    Route::get('/qanswer/list', 'AQanswerController@index');
    Route::get('/qanswer/create', 'AQanswerController@create');
    Route::get('/qanswer/edit/{id}', 'AQanswerController@edit');
    Route::get('/qanswer/delete/{id}', 'AQanswerController@delete');
    Route::get('/qanswer/copy/{id}', 'AQanswerController@copy');
    Route::post('/qanswer/store', 'AQanswerController@store');
    Route::get('/qanswer/getSpeciality', 'AQanswerController@getSpeciality');
    Route::get('/qanswer/getCategory', 'AQanswerController@getCategory');
    Route::post('/qanswer/table', 'AQanswerController@table');


    //Country API
    Route::get('/country/list', 'ACountryController@index');
    Route::get('/country/create', 'ACountryController@create' );
    Route::get('/country/edit/{id}', 'ACountryController@edit' );
    Route::get('/country/delete/{id}', 'ACountryController@delete');
    Route::get('/country/copy/{id}', 'ACountryController@copy');
    Route::post('/country/store', 'ACountryController@store');
    Route::get('/country/getall', 'AAreaController@formData');
    Route::get('/country/getAllCity/{id}', 'ACountryController@getAllCity');
    Route::post('/country/table', 'ACountryController@table');

    //City API
    Route::get('/city/list', 'ACityController@index');
    Route::get('/city/create', 'ACityController@create' );
    Route::get('/city/edit/{id}', 'ACityController@edit' );
    Route::get('/city/delete/{id}', 'ACityController@delete' );
    Route::get('/city/copy/{id}', 'ACityController@copy');
    Route::post('/city/store', 'ACityController@store' );
    Route::post('/city/table', 'ACityController@table');
    Route::get('/city/getAllArea/{id}', 'ACityController@getAllArea');
    //Area API
    Route::get('/area/list', 'AAreaController@index' );
    Route::get('/area/create', 'AAreaController@create'  );
    Route::get('/area/edit/{id}', 'AAreaController@edit'  );
    Route::get('/area/delete/{id}', 'AAreaController@delete'  );
    Route::get('/area/copy/{id}', 'AAreaController@copy' );
    Route::post('/area/store', 'AAreaController@store'  );
    Route::post('/area/table', 'AAreaController@table');

    //speciality API
    Route::get('/specialty/list', 'ASpecialtyController@index');
    Route::get('/specialty/create', 'ASpecialtyController@create');
    Route::get('/specialty/edit/{id}', 'ASpecialtyController@edit');
    Route::get('/specialty/delete/{id}', 'ASpecialtyController@delete');
    Route::get('/specialty/copy/{id}', 'ASpecialtyController@copy');
    Route::post('/specialty/store', 'ASpecialtyController@store');
    Route::post('/specialty/table', 'ASpecialtyController@table');

    //Page API
    Route::get('/pages/list', 'APageController@index');
    Route::get('/pages/create', 'APageController@create');
    Route::get('/pages/edit/{id}', 'APageController@edit');
    Route::get('/pages/delete/{id}', 'APageController@delete');
    Route::get('/pages/copy/{id}', 'APageController@copy');
    Route::post('/pages/store', 'APageController@store');
    Route::post('/pages/table', 'APageController@table');

    //Faq API
    Route::get('/faqs/list', 'AFaqController@index');
    Route::get('/faqs/create', 'AFaqController@create' );
    Route::get('/faqs/edit/{id}', 'AFaqController@edit');
    Route::get('/faqs/delete/{id}', 'AFaqController@delete');
    Route::get('/faqs/copy/{id}', 'AFaqController@copy');
    Route::post('/faqs/store', 'AFaqController@store' );
    Route::post('/faqs/table', 'AFaqController@table');

    //Role API
    Route::get('/role/list', 'ARoleController@index');
    Route::get('/role/create', 'ARoleController@create');
    Route::get('/role/edit/{id}','ARoleController@edit');
    Route::get('/role/delete/{id}', 'ARoleController@delete');
    Route::get('/role/copy/{id}', 'ARoleController@copy');
    Route::post('/role/store', 'ARoleController@store');
    Route::get('/role/all', 'ARoleController@getTotalRole');
    Route::post('/role/table', 'ARoleController@table');

    //User API
    Route::get('/user/list', 'AUserController@index'  );
    Route::get('/user/index_admin', 'AUserController@index_admin' );
    Route::get('/user/index_moderator', 'AUserController@index_moderator'  );
    Route::get('/user/index_doctors','AUserController@index_doctors'  );
    Route::get('/user/index_users', 'AUserController@index_users'  );
    Route::post('/user/table', 'AUserController@table');

    Route::get('/user/create', 'AUserController@create' );
    Route::get('/user/edit/{id}', 'AUserController@edit' );
    Route::get('/user/delete/{id}', 'AUserController@delete');
    Route::get('/user/copy/{id}', 'AUserController@copy' );
    Route::post('/user/store','AUserController@store' );

    //Multiple Image process
    Route::any('/data/uploadImages', 'ADataFormController@uploadImages');

});