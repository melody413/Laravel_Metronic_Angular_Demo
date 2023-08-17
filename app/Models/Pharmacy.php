<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Pharmacy extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\PharmacyTrans';

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
        'open_hours',
        'is_active',
        'user_id',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'website',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('pharmacies.*');
        $query->addSelect('pharmacy_trans.name as name');
        $query->join('pharmacy_trans', 'pharmacy_id', '=', 'pharmacies.id');
        $query->where('pharmacy_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }
    
    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id')->withTranslation();
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area_id')->withTranslation();
    }

    public function insuranceCompanies()
    {
        return $this->morphToMany('App\Models\InsuranceCompany', 'insurance_companyable');
    }

    public function getInsuranceCompanies()
    {
        return $this->insuranceCompanies()->where('is_active',1)->orderBy('id','DESC')->get();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
