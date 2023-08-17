<?php

Route::group(['namespace' => 'Admin' , 'prefix' => env('ADMIN_PREFIX') ], function () {
    Route::get('/login', ['uses' => 'UserController@showLogin' , 'as'=>'admin.user.login'] );
    Route::post('/login', ['uses' => 'UserController@login' , 'as'=>'admin.user.post_login'] );
    Route::get('/logout', ['uses' => 'UserController@logout' , 'as'=>'admin.user.logout'] );
});

Route::group(['namespace' => 'Admin' , 'prefix' => env('ADMIN_PREFIX'), 'middleware' => ['AdminAuth','AdminCheckPermission'] ], function () {
    Route::get('/', ['uses' => 'DashboardController@home' , 'as'=>'admin.dashboard'] );
    Route::get('/data/pharamcyInfo/{id}', ['uses' => 'DataFormController@pharamcyInfo' , 'as'=>'admin.dataFrom.pharamcyInfo'] );
    Route::get('/data/labInfo/{id}', ['uses' => 'DataFormController@labInfo' , 'as'=>'admin.dataFrom.labInfo'] );
    Route::get('/data/getHospitals/{q}', ['uses' => 'DataFormController@getHospitals' , 'as'=>'admin.dataFrom.getHospital'] );
    Route::get('/data/getHospitals', ['uses' => 'DataFormController@getHospitals' , 'as'=>'admin.dataFrom.labInfo'] );
    Route::get('/data/getCenters/{q}', ['uses' => 'DataFormController@getCenters' , 'as'=>'admin.dataFrom.labInfo'] );
    Route::get('/data/getCenters', ['uses' => 'DataFormController@getCenters' , 'as'=>'admin.dataFrom.labInfo'] );
    Route::get('/data/getSubsBySub/{q}', ['uses' => 'DataFormController@getSubsBySub' , 'as'=>'admin.dataFrom.getSubs'] );
    Route::get('/data/getSubsBySpecialty/{q}', ['uses' => 'DataFormController@getSubsBySpecialty' , 'as'=>'admin.dataFrom.getSubs'] );
    Route::get('/data/getSymptomsByBodyPart/{q}', ['uses' => 'DataFormController@getSymptomsByBodyPart' , 'as'=>'admin.dataFrom.getSubs'] );
    Route::get('/data/getUser', ['uses' => 'DataFormController@getUser' , 'as'=>'admin.dataFrom.labInfo'] );
    Route::get('/data/getInsuranceCompanies', ['uses' => 'DataFormController@getInsuranceCompanies' , 'as'=>'admin.dataFrom.getInsuranceCompany'] );
    Route::any('/data/uploadImages', ['uses' => 'DataFormController@uploadImages' , 'as'=>'admin.dataFrom.uploadImages'] );
    // Route::post('file-remove', [FileUploadController::class, 'removeFileUploadPost'])->name('file.remove.post');

    Route::get('/pages/index', ['uses' => 'PageController@index' , 'as'=>'admin.page.index'] );
    Route::get('/pages/create', ['uses' => 'PageController@create' , 'as'=>'admin.page.create'] );
    Route::get('/pages/edit/{id}', ['uses' => 'PageController@edit' , 'as'=>'admin.page.edit'] );
    Route::get('/pages/delete/{id}', ['uses' => 'PageController@delete' , 'as'=>'admin.page.delete'] );
    Route::get('/pages/copy/{id}', ['uses' => 'PageController@copy' , 'as'=>'admin.page.copy'] );
    Route::post('/pages/store', ['uses' => 'PageController@store' , 'as'=>'admin.page.store'] );

    Route::get('/faqs/index', ['uses' => 'FaqController@index' , 'as'=>'admin.faq.index'] );
    Route::get('/faqs/create', ['uses' => 'FaqController@create' , 'as'=>'admin.faq.create'] );
    Route::get('/faqs/edit/{id}', ['uses' => 'FaqController@edit' , 'as'=>'admin.faq.edit'] );
    Route::get('/faqs/delete/{id}', ['uses' => 'FaqController@delete' , 'as'=>'admin.faq.delete'] );
    Route::get('/faqs/copy/{id}', ['uses' => 'FaqController@copy' , 'as'=>'admin.faq.copy'] );
    Route::post('/faqs/store', ['uses' => 'FaqController@store' , 'as'=>'admin.faq.store'] );

    Route::get('/country/index', ['uses' => 'CountryController@index' , 'as'=>'admin.country.index'] );
    Route::get('/country/create', ['uses' => 'CountryController@create' , 'as'=>'admin.country.create'] );
    Route::get('/country/edit/{id}', ['uses' => 'CountryController@edit' , 'as'=>'admin.country.edit'] );
    Route::get('/country/delete/{id}', ['uses' => 'CountryController@delete' , 'as'=>'admin.country.delete'] );
    Route::get('/country/copy/{id}', ['uses' => 'CountryController@copy' , 'as'=>'admin.country.copy'] );
    Route::post('/country/store', ['uses' => 'CountryController@store' , 'as'=>'admin.country.store'] );

    Route::get('/city/index', ['uses' => 'CityController@index' , 'as'=>'admin.city.index'] );
    Route::get('/city/create', ['uses' => 'CityController@create' , 'as'=>'admin.city.create'] );
    Route::get('/city/edit/{id}', ['uses' => 'CityController@edit' , 'as'=>'admin.city.edit'] );
    Route::get('/city/delete/{id}', ['uses' => 'CityController@delete' , 'as'=>'admin.city.delete'] );
    Route::get('/city/copy/{id}', ['uses' => 'CityController@copy' , 'as'=>'admin.city.copy'] );
    Route::post('/city/store', ['uses' => 'CityController@store' , 'as'=>'admin.city.store'] );

    Route::get('/area/index', ['uses' => 'AreaController@index' , 'as'=>'admin.area.index'] );
    Route::get('/area/create', ['uses' => 'AreaController@create' , 'as'=>'admin.area.create'] );
    Route::get('/area/edit/{id}', ['uses' => 'AreaController@edit' , 'as'=>'admin.area.edit'] );
    Route::get('/area/delete/{id}', ['uses' => 'AreaController@delete' , 'as'=>'admin.area.delete'] );
    Route::get('/area/copy/{id}', ['uses' => 'AreaController@copy' , 'as'=>'admin.area.copy'] );
    Route::post('/area/store', ['uses' => 'AreaController@store' , 'as'=>'admin.area.store'] );

    Route::get('/specialty/index', ['uses' => 'SpecialtyController@index' , 'as'=>'admin.specialty.index'] );
    Route::get('/specialty/create', ['uses' => 'SpecialtyController@create' , 'as'=>'admin.specialty.create'] );
    Route::get('/specialty/edit/{id}', ['uses' => 'SpecialtyController@edit' , 'as'=>'admin.specialty.edit'] );
    Route::get('/specialty/delete/{id}', ['uses' => 'SpecialtyController@delete' , 'as'=>'admin.specialty.delete'] );
    Route::get('/specialty/copy/{id}', ['uses' => 'SpecialtyController@copy' , 'as'=>'admin.specialty.copy'] );
    Route::post('/specialty/store', ['uses' => 'SpecialtyController@store' , 'as'=>'admin.specialty.store'] );

    Route::get('/hospital_type/index', ['uses' => 'HospitalTypeController@index' , 'as'=>'admin.hospital_type.index'] );
    Route::get('/hospital_type/create', ['uses' => 'HospitalTypeController@create' , 'as'=>'admin.hospital_type.create'] );
    Route::get('/hospital_type/edit/{id}', ['uses' => 'HospitalTypeController@edit' , 'as'=>'admin.hospital_type.edit'] );
    Route::get('/hospital_type/delete/{id}', ['uses' => 'HospitalTypeController@delete' , 'as'=>'admin.hospital_type.delete'] );
    Route::get('/hospital_type/copy/{id}', ['uses' => 'HospitalTypeController@copy' , 'as'=>'admin.hospital_type.copy'] );
    Route::post('/hospital_type/store', ['uses' => 'HospitalTypeController@store' , 'as'=>'admin.hospital_type.store'] );

    Route::get('/pharmacy/index', ['uses' => 'PharmacyController@index' , 'as'=>'admin.pharmacy.index'] );
    Route::get('/pharmacy/create', ['uses' => 'PharmacyController@create' , 'as'=>'admin.pharmacy.create'] );
    Route::get('/pharmacy/edit/{id}', ['uses' => 'PharmacyController@edit' , 'as'=>'admin.pharmacy.edit'] );
    Route::get('/pharmacy/delete/{id}', ['uses' => 'PharmacyController@delete' , 'as'=>'admin.pharmacy.delete'] );
    Route::get('/pharmacy/copy/{id}', ['uses' => 'PharmacyController@copy' , 'as'=>'admin.pharmacy.copy'] );
    Route::post('/pharmacy/store', ['uses' => 'PharmacyController@store' , 'as'=>'admin.pharmacy.store'] );

    Route::get('/lab/index', ['uses' => 'LabController@index' , 'as'=>'admin.lab.index'] );
    Route::get('/lab/create', ['uses' => 'LabController@create' , 'as'=>'admin.lab.create'] );
    Route::get('/lab/edit/{id}', ['uses' => 'LabController@edit' , 'as'=>'admin.lab.edit'] );
    Route::get('/lab/delete/{id}', ['uses' => 'LabController@delete' , 'as'=>'admin.lab.delete'] );
    Route::get('/lab/copy/{id}', ['uses' => 'LabController@copy' , 'as'=>'admin.lab.copy'] );
    Route::post('/lab/store', ['uses' => 'LabController@store' , 'as'=>'admin.lab.store'] );

    Route::get('/lab_services/index', ['uses' => 'LabServiceController@index' , 'as'=>'admin.lab_service.index'] );
    Route::get('/lab_services/create', ['uses' => 'LabServiceController@create' , 'as'=>'admin.lab_service.create'] );
    Route::get('/lab_services/edit/{id}', ['uses' => 'LabServiceController@edit' , 'as'=>'admin.lab_service.edit'] );
    Route::get('/lab_services/delete/{id}', ['uses' => 'LabServiceController@delete' , 'as'=>'admin.lab_service.delete'] );
    Route::get('/lab_services/copy/{id}', ['uses' => 'LabServiceController@copy' , 'as'=>'admin.lab_service.copy'] );
    Route::post('/lab_services/store', ['uses' => 'LabServiceController@store' , 'as'=>'admin.lab_service.store'] );

    Route::get('/insurance_company/index', ['uses' => 'InsuranceCompanyController@index' , 'as'=>'admin.insurance_company.index'] );
    Route::get('/insurance_company/create', ['uses' => 'InsuranceCompanyController@create' , 'as'=>'admin.insurance_company.create'] );
    Route::get('/insurance_company/edit/{id}', ['uses' => 'InsuranceCompanyController@edit' , 'as'=>'admin.insurance_company.edit'] );
    Route::get('/insurance_company/delete/{id}', ['uses' => 'InsuranceCompanyController@delete' , 'as'=>'admin.insurance_company.delete'] );
    Route::get('/insurance_company/copy/{id}', ['uses' => 'InsuranceCompanyController@copy' , 'as'=>'admin.insurance_company.copy'] );
    Route::post('/insurance_company/store', ['uses' => 'InsuranceCompanyController@store' , 'as'=>'admin.insurance_company.store'] );

    Route::get('/hospital/index', ['uses' => 'HospitalController@index' , 'as'=>'admin.hospital.index'] );
    Route::get('/hospital/create', ['uses' => 'HospitalController@create' , 'as'=>'admin.hospital.create'] );
    Route::get('/hospital/edit/{id}', ['uses' => 'HospitalController@edit' , 'as'=>'admin.hospital.edit'] );
    Route::get('/hospital/delete/{id}', ['uses' => 'HospitalController@delete' , 'as'=>'admin.hospital.delete'] );
    Route::get('/hospital/copy/{id}', ['uses' => 'HospitalController@copy' , 'as'=>'admin.hospital.copy'] );
    Route::post('/hospital/store', ['uses' => 'HospitalController@store' , 'as'=>'admin.hospital.store'] );

    Route::get('/center/index', ['uses' => 'CenterController@index' , 'as'=>'admin.center.index'] );
    Route::get('/center/create', ['uses' => 'CenterController@create' , 'as'=>'admin.center.create'] );
    Route::get('/center/edit/{id}', ['uses' => 'CenterController@edit' , 'as'=>'admin.center.edit'] );
    Route::get('/center/delete/{id}', ['uses' => 'CenterController@delete' , 'as'=>'admin.center.delete'] );
    Route::get('/center/copy/{id}', ['uses' => 'CenterController@copy' , 'as'=>'admin.center.copy'] );
    Route::post('/center/store', ['uses' => 'CenterController@store' , 'as'=>'admin.center.store'] );

    Route::get('/tag/index', ['uses' => 'TagController@index' , 'as'=>'admin.tag.index'] );
    Route::get('/tag/create', ['uses' => 'TagController@create' , 'as'=>'admin.tag.create'] );
    Route::get('/tag/edit/{id}', ['uses' => 'TagController@edit' , 'as'=>'admin.tag.edit'] );
    Route::get('/tag/delete/{id}', ['uses' => 'TagController@delete' , 'as'=>'admin.tag.delete'] );
    Route::get('/tag/copy/{id}', ['uses' => 'TagController@copy' , 'as'=>'admin.tag.copy'] );
    Route::post('/tag/store', ['uses' => 'TagController@store' , 'as'=>'admin.tag.store'] );

    Route::get('/sub_category/index', ['uses' => 'SubCategoryController@index' , 'as'=>'admin.sub_category.index'] );
    Route::get('/sub_category/create', ['uses' => 'SubCategoryController@create' , 'as'=>'admin.sub_category.create'] );
    Route::get('/sub_category/edit/{id}', ['uses' => 'SubCategoryController@edit' , 'as'=>'admin.sub_category.edit'] );
    Route::get('/sub_category/delete/{id}', ['uses' => 'SubCategoryController@delete' , 'as'=>'admin.sub_category.delete'] );
    Route::get('/sub_category/copy/{id}', ['uses' => 'SubCategoryController@copy' , 'as'=>'admin.sub_category.copy'] );
    Route::post('/sub_category/store', ['uses' => 'SubCategoryController@store' , 'as'=>'admin.sub_category.store'] );

    Route::get('/body_part/index', ['uses' => 'BodyPartController@index' , 'as'=>'admin.body_part.index'] );
    Route::get('/body_part/create', ['uses' => 'BodyPartController@create' , 'as'=>'admin.body_part.create'] );
    Route::get('/body_part/edit/{id}', ['uses' => 'BodyPartController@edit' , 'as'=>'admin.body_part.edit'] );
    Route::get('/body_part/delete/{id}', ['uses' => 'BodyPartController@delete' , 'as'=>'admin.body_part.delete'] );
    Route::get('/body_part/copy/{id}', ['uses' => 'BodyPartController@copy' , 'as'=>'admin.body_part.copy'] );
    Route::post('/body_part/store', ['uses' => 'BodyPartController@store' , 'as'=>'admin.body_part.store'] );

    Route::get('/symptom/index', ['uses' => 'SymptomController@index' , 'as'=>'admin.symptom.index'] );
    Route::get('/symptom/create', ['uses' => 'SymptomController@create' , 'as'=>'admin.symptom.create'] );
    Route::get('/symptom/edit/{id}', ['uses' => 'SymptomController@edit' , 'as'=>'admin.symptom.edit'] );
    Route::get('/symptom/delete/{id}', ['uses' => 'SymptomController@delete' , 'as'=>'admin.symptom.delete'] );
    Route::get('/symptom/copy/{id}', ['uses' => 'SymptomController@copy' , 'as'=>'admin.symptom.copy'] );
    Route::post('/symptom/store', ['uses' => 'SymptomController@store' , 'as'=>'admin.symptom.store'] );

    Route::get('/disease/index', ['uses' => 'DiseaseController@index' , 'as'=>'admin.disease.index'] );
    Route::get('/disease/create', ['uses' => 'DiseaseController@create' , 'as'=>'admin.disease.create'] );
    Route::get('/disease/edit/{id}', ['uses' => 'DiseaseController@edit' , 'as'=>'admin.disease.edit'] );
    Route::get('/disease/delete/{id}', ['uses' => 'DiseaseController@delete' , 'as'=>'admin.disease.delete'] );
    Route::get('/disease/copy/{id}', ['uses' => 'DiseaseController@copy' , 'as'=>'admin.disease.copy'] );
    Route::post('/disease/store', ['uses' => 'DiseaseController@store' , 'as'=>'admin.disease.store'] );

    Route::get('/qanswer/index', ['uses' => 'QanswerController@index' , 'as'=>'admin.qanswer.index'] );
    Route::get('/qanswer/create', ['uses' => 'QanswerController@create' , 'as'=>'admin.qanswer.create'] );
    Route::get('/qanswer/edit/{id}', ['uses' => 'QanswerController@edit' , 'as'=>'admin.qanswer.edit'] );
    Route::get('/qanswer/delete/{id}', ['uses' => 'QanswerController@delete' , 'as'=>'admin.qanswer.delete'] );
    Route::get('/qanswer/copy/{id}', ['uses' => 'QanswerController@copy' , 'as'=>'admin.qanswer.copy'] );
    Route::post('/qanswer/store', ['uses' => 'QanswerController@store' , 'as'=>'admin.qanswer.store'] );

    Route::get('/medicines/index', ['uses' => 'MedicineController@index' , 'as'=>'admin.medicine.index'] );
    Route::get('/medicines/create', ['uses' => 'MedicineController@create' , 'as'=>'admin.medicine.create'] );
    Route::get('/medicines/edit/{id}', ['uses' => 'MedicineController@edit' , 'as'=>'admin.medicine.edit'] );
    Route::get('/medicines/delete/{id}', ['uses' => 'MedicineController@delete' , 'as'=>'admin.medicine.delete'] );
    Route::get('/medicines/copy/{id}', ['uses' => 'MedicineController@copy' , 'as'=>'admin.medicine.copy'] );
    Route::post('/medicines/store', ['uses' => 'MedicineController@store' , 'as'=>'admin.medicine.store'] );

    Route::get('/medicines_company/index', ['uses' => 'MedicinesCompanyController@index' , 'as'=>'admin.medicines_company.index'] );
    Route::get('/medicines_company/create', ['uses' => 'MedicinesCompanyController@create' , 'as'=>'admin.medicines_company.create'] );
    Route::get('/medicines_company/edit/{id}', ['uses' => 'MedicinesCompanyController@edit' , 'as'=>'admin.medicines_company.edit'] );
    Route::get('/medicines_company/delete/{id}', ['uses' => 'MedicinesCompanyController@delete' , 'as'=>'admin.medicines_company.delete'] );
    Route::get('/medicines_company/copy/{id}', ['uses' => 'MedicinesCompanyController@copy' , 'as'=>'admin.medicines_company.copy'] );
    Route::post('/medicines_company/store', ['uses' => 'MedicinesCompanyController@store' , 'as'=>'admin.medicines_company.store'] );

    Route::get('/medicines_category/index', ['uses' => 'MedicinesCategoryController@index' , 'as'=>'admin.medicines_category.index'] );
    Route::get('/medicines_category/create', ['uses' => 'MedicinesCategoryController@create' , 'as'=>'admin.medicines_category.create'] );
    Route::get('/medicines_category/edit/{id}', ['uses' => 'MedicinesCategoryController@edit' , 'as'=>'admin.medicines_category.edit'] );
    Route::get('/medicines_category/delete/{id}', ['uses' => 'MedicinesCategoryController@delete' , 'as'=>'admin.medicines_category.delete'] );
    Route::get('/medicines_category/copy/{id}', ['uses' => 'MedicinesCategoryController@copy' , 'as'=>'admin.medicines_category.copy'] );
    Route::post('/medicines_category/store', ['uses' => 'MedicinesCategoryController@store' , 'as'=>'admin.medicines_category.store'] );

    Route::get('/medicines_sc_name/index', ['uses' => 'MedicinesScNamesController@index' , 'as'=>'admin.medicines_sc_name.index'] );
    Route::get('/medicines_sc_name/create', ['uses' => 'MedicinesScNamesController@create' , 'as'=>'admin.medicines_sc_name.create'] );
    Route::get('/medicines_sc_name/edit/{id}', ['uses' => 'MedicinesScNamesController@edit' , 'as'=>'admin.medicines_sc_name.edit'] );
    Route::get('/medicines_sc_name/delete/{id}', ['uses' => 'MedicinesScNamesController@delete' , 'as'=>'admin.medicines_sc_name.delete'] );
    Route::get('/medicines_sc_name/copy/{id}', ['uses' => 'MedicinesScNamesController@copy' , 'as'=>'admin.medicines_sc_name.copy'] );
    Route::post('/medicines_sc_name/store', ['uses' => 'MedicinesScNamesController@store' , 'as'=>'admin.medicines_sc_name.store'] );

    Route::get('/doctor/index', ['uses' => 'DoctorController@index' , 'as'=>'admin.doctor.index'] );
    Route::get('/doctor/create', ['uses' => 'DoctorController@create' , 'as'=>'admin.doctor.create'] );
    Route::get('/doctor/edit/{id}', ['uses' => 'DoctorController@edit' , 'as'=>'admin.doctor.edit'] );
    Route::get('/doctor/delete/{id}', ['uses' => 'DoctorController@delete' , 'as'=>'admin.doctor.delete'] );
    Route::post('/doctor/store', ['uses' => 'DoctorController@store' , 'as'=>'admin.doctor.store'] );

    Route::get('/doctor/rate/{id}', ['uses' => 'DoctorRateController@index' , 'as'=>'admin.doctor_rate.index'] );
    Route::get('/doctor/rate/delete/{id}', ['uses' => 'DoctorRateController@delete' , 'as'=>'admin.doctor_rate.delete'] );
    Route::get('/doctor/rate/toggleActive/{id}', ['uses' => 'DoctorRateController@toggleActive' , 'as'=>'admin.doctor_rate.toggle_active'] );

    Route::get('/doctor/branch/{id}', ['uses' => 'DoctorBranchController@index' , 'as'=>'admin.doctor_branch.index'] );
    Route::get('/doctor/branch/create/{id}', ['uses' => 'DoctorBranchController@create' , 'as'=>'admin.doctor_branch.create'] );
    Route::get('/doctor/branch/edit/{id}', ['uses' => 'DoctorBranchController@edit' , 'as'=>'admin.doctor_branch.edit'] );
    Route::post('/doctor/branch/store', ['uses' => 'DoctorBranchController@store' , 'as'=>'admin.doctor_branch.store'] );
    Route::get('/doctor/branch/delete/{id}', ['uses' => 'DoctorBranchController@delete' , 'as'=>'admin.doctor_branch.delete'] );
    Route::get('/doctor/branch/toggleActive/{id}', ['uses' => 'DoctorBranchController@toggleActive' , 'as'=>'admin.doctor_branch.toggle_active'] );

    Route::get('/reservation/{id}', ['uses' => 'ReservationController@index' , 'as'=>'admin.reservation.index'] );
    Route::get('/reservation', ['uses' => 'ReservationController@index' , 'as'=>'admin.reservation.index'] );
    #Route::get('/reservation/create/{id}', ['uses' => 'ReservationController@create' , 'as'=>'admin.reservation.create'] );
    Route::get('/reservation/edit/{id}', ['uses' => 'ReservationController@edit' , 'as'=>'admin.reservation.edit'] );
    Route::post('/reservation/store', ['uses' => 'ReservationController@store' , 'as'=>'admin.reservation.store'] );
    Route::get('/reservation/delete/{id}', ['uses' => 'ReservationController@delete' , 'as'=>'admin.reservation.delete'] );
    Route::get('/reservation/view/{id}', ['uses' => 'ReservationController@view' , 'as'=>'admin.reservation.view'] );

    Route::get('/role/index', ['uses' => 'RoleController@index' , 'as'=>'admin.role.index'] );
    Route::get('/role/create', ['uses' => 'RoleController@create' , 'as'=>'admin.role.create'] );
    Route::get('/role/edit/{id}', ['uses' => 'RoleController@edit' , 'as'=>'admin.role.edit'] );
    Route::get('/role/delete/{id}', ['uses' => 'RoleController@delete' , 'as'=>'admin.role.delete'] );
    Route::get('/role/copy/{id}', ['uses' => 'RoleController@copy' , 'as'=>'admin.role.copy'] );
    Route::post('/role/store', ['uses' => 'RoleController@store' , 'as'=>'admin.role.store'] );

    Route::get('/user/index', ['uses' => 'UserController@index' , 'as'=>'admin.user.index'] );
    Route::get('/user/index_admin', ['uses' => 'UserController@index_admin' , 'as'=>'admin.user.index_doctors'] );
    Route::get('/user/index_moderator', ['uses' => 'UserController@index_moderator' , 'as'=>'admin.user.index_doctors'] );
    Route::get('/user/index_doctors', ['uses' => 'UserController@index_doctors' , 'as'=>'admin.user.index_doctors'] );
    Route::get('/user/index_users', ['uses' => 'UserController@index_users' , 'as'=>'admin.user.index_users'] );

    Route::get('/user/create', ['uses' => 'UserController@create' , 'as'=>'admin.user.create'] );
    Route::get('/user/edit/{id}', ['uses' => 'UserController@edit' , 'as'=>'admin.user.edit'] );
    Route::get('/user/delete/{id}', ['uses' => 'UserController@delete' , 'as'=>'admin.user.delete'] );
    Route::get('/user/copy/{id}', ['uses' => 'UserController@copy' , 'as'=>'admin.user.copy'] );
    Route::post('/user/store', ['uses' => 'UserController@store' , 'as'=>'admin.user.store'] );

    Route::get('/log/index/{model}/{id}', ['uses' => 'LogController@index' , 'as'=>'admin.log.index'] );

    Route::get('/pharmacy_company/index', ['uses' => 'PharmacyCompanyController@index' , 'as'=>'admin.pharmacy_company.index'] );
    Route::get('/pharmacy_company/create', ['uses' => 'PharmacyCompanyController@create' , 'as'=>'admin.pharmacy_company.create'] );
    Route::get('/pharmacy_company/edit/{id}', ['uses' => 'PharmacyCompanyController@edit' , 'as'=>'admin.pharmacy_company.edit'] );
    Route::get('/pharmacy_company/delete/{id}', ['uses' => 'PharmacyCompanyController@delete' , 'as'=>'admin.pharmacy_company.delete'] );
    Route::get('/pharmacy_company/copy/{id}', ['uses' => 'PharmacyCompanyController@copy' , 'as'=>'admin.pharmacy_company.copy'] );
    Route::post('/pharmacy_company/store', ['uses' => 'PharmacyCompanyController@store' , 'as'=>'admin.pharmacy_company.store'] );

    Route::get('/lab_company/index', ['uses' => 'LabCompanyController@index' , 'as'=>'admin.lab_company.index'] );
    Route::get('/lab_company/create', ['uses' => 'LabCompanyController@create' , 'as'=>'admin.lab_company.create'] );
    Route::get('/lab_company/edit/{id}', ['uses' => 'LabCompanyController@edit' , 'as'=>'admin.lab_company.edit'] );
    Route::get('/lab_company/delete/{id}', ['uses' => 'LabCompanyController@delete' , 'as'=>'admin.lab_company.delete'] );
    Route::get('/lab_company/copy/{id}', ['uses' => 'LabCompanyController@copy' , 'as'=>'admin.lab_company.copy'] );
    Route::post('/lab_company/store', ['uses' => 'LabCompanyController@store' , 'as'=>'admin.lab_company.store'] );

    Route::get('/lab_category/index', ['uses' => 'LabCategoryController@index' , 'as'=>'admin.lab_category.index'] );
    Route::get('/lab_category/create', ['uses' => 'LabCategoryController@create' , 'as'=>'admin.lab_category.create'] );
    Route::get('/lab_category/edit/{id}', ['uses' => 'LabCategoryController@edit' , 'as'=>'admin.lab_category.edit'] );
    Route::get('/lab_category/delete/{id}', ['uses' => 'LabCategoryController@delete' , 'as'=>'admin.lab_category.delete'] );
    Route::get('/lab_category/copy/{id}', ['uses' => 'LabCategoryController@copy' , 'as'=>'admin.lab_category.copy'] );
    Route::post('/lab_category/store', ['uses' => 'LabCategoryController@store' , 'as'=>'admin.lab_category.store'] );


});
