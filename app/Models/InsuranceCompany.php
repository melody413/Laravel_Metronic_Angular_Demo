<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class InsuranceCompany extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\InsuranceCompanyTrans';

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
        'shortcuts',
        'is_active',
    ];


    public function scopeSearch($query, $search)
    {
        $query->select('insurance_companies.*');
        $query->addSelect('insurance_company_trans.name as name');
        $query->join('insurance_company_trans', 'insurance_company_id', '=', 'insurance_companies.id');
        $query->where('insurance_company_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }


    public function doctors()
    {
        return $this->morphedByMany('App\Models\Doctor', 'insurance_companyable')->withTranslation();
    }

    public function labs()
    {
        return $this->morphedByMany('App\Models\Lab', 'insurance_companyable')->withTranslation();
    }

    public function insurance_companies()
    {
        return $this->morphedByMany('App\Models\Hospital', 'insurance_companyable')->withTranslation();
    }

    public function pharmacy()
    {
        return $this->morphedByMany('App\Models\Pharmacy', 'insurance_companyable')->withTranslation();
    }

    public function getDoctors()
    {
        return $this->doctors()->where('is_active',1)->orderBy('id', 'DESC')->get();
    }

    public function getlabs()
    {
        return $this->labs()->where('is_active',1)->orderBy('id', 'DESC')->get();
    }

    public function getHospitals()
    {
        return $this->insurance_companies()->where('is_active',1)->orderBy('id', 'DESC')->get();
    }

    public function getPharmacy()
    {
        return $this->pharmacy()->where('is_active',1)->orderBy('id', 'DESC')->get();
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
