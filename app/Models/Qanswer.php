<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Qanswer extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\QanswerTrans';

    public $translatedAttributes = [
        'name',
    ];

    public $fillable = [
        'image',
        'country_id',
        'module_name',
        'is_active',
        'user_id',
    ];

    public function specialties()
    {
        return $this->belongsToMany('App\Models\Specialty');
    }
    public function medicine_categories()
    {
        return $this->belongsToMany('App\Models\MedicinesCategory', 'qanswer_medicine_category');
    }
    public function insuranceCompanies()
    {
        return $this->morphToMany('App\Models\InsuranceCompany', 'insurance_companyable')->withTranslation();
    }

    public function getInsuranceCompanies()
    {
        return $this->insuranceCompanies()->withTranslation()->where('is_active',1)->orderBy('id','DESC')->get();
    }

    public function doctors()
    {
        return $this->belongsToMany('App\Models\Doctor');
    }

    public function getDoctors()
    {
        return $this->doctors()->where('is_active',1)->orderBy('id','DESC')->get();
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id')->withTranslation();
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area_id')->withTranslation();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
