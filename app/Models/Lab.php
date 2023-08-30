<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Lab extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\LabTrans';

    public $translatedAttributes = [
        'name',
        'excerpt',
        'description',
        'address',

    ];

    public $fillable = [
        'image',
        'lat_lng',
        'phone',
        'parent_id',
        'country_id',
        'city_id',
        'area_id',
        'map_link',
        'shortcuts',
        'is_active',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('labs.*');
        $query->addSelect('lab_trans.name as name');
        $query->join('lab_trans', 'lab_id', '=', 'labs.id');
        $query->where('lab_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }

    public function labServices()
    {
        return $this->belongsToMany('App\Models\LabService');
    }

    public function insuranceCompanies()
    {
        return $this->morphToMany('App\Models\InsuranceCompany', 'insurance_companyable');
    }

    public function getInsuranceCompanies()
    {
        return $this->morphToMany('App\Models\InsuranceCompany', 'insurance_companyable')->where('is_active',1)->orderBy('id','DESC')->get();
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id')->withTranslation();
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area_id')->withTranslation();
    }



}
