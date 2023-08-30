<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Disease extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\DiseaseTrans';

    public $translatedAttributes = [
        'name',
        'excerpt',
        'description',
        'symptoms',
        'causes',
        'complications',
        'diagnosis',
        'treatment',
        'protection',
        'alternative_therapies',
    ];

    public $fillable = [
        'image',
        'parent_ids',
        'body_part_ids',
        'symptom_ids',
        'is_active',
        'user_id',
    ];

    public function specialties()
    {
        return $this->belongsToMany('App\Models\Specialty');
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
