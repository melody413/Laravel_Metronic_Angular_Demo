<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Center extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\CenterTrans';

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
        'map_link',
        'parent_id',
        'country_id',
        'city_id',
        'area_id',
        'shortcuts',
        'is_active',
        'user_id',
        'tags_en',
        'sub_cats_en',
        'tags_ar',
        'sub_cats_ar',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('centers.*');
        $query->addSelect('center_trans.name as name');
        $query->join('center_trans', 'center_id', '=', 'centers.id');
        $query->where('center_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }
    
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
