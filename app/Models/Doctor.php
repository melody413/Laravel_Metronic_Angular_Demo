<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Doctor extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\DoctorTrans';

    public $translatedAttributes = [
        'name',
        'title',
        'excerpt',
        'description',
    ];

    public $fillable = [
        'image',
        'gender',
        'wait_time',
        'price',
        'phone',
        'country_id',
        'city_id',
        'area_id',
        'is_reserve',
        'is_active',
        'address',
        'map_link',
        'user_id',
        'user_entry_id',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'website',
        'tags_en',
        'sub_cats_en',
        'tags_ar',
        'sub_cats_ar',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('doctors.*');
        $query->addSelect('doctor_trans.name as name');
        $query->join('doctor_trans', 'doctor_id', '=', 'doctors.id');
        $query->where('doctor_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }
    
    public function specialties()
    {
        return $this->belongsToMany('App\Models\Specialty')->orderBy('updated_at', 'desc');
    }

    public function hospitals()
    {
        return $this->belongsToMany('App\Models\Hospital')->orderBy('updated_at', 'desc')->withTranslation();
    }
    public function centers()
    {
        return $this->belongsToMany('App\Models\Center')->orderBy('updated_at', 'desc')->withTranslation();
    }

    public function insuranceCompanies()
    {
        return $this->morphToMany('App\Models\InsuranceCompany', 'insurance_companyable')->withTranslation();
    }

    public function branches()
    {
        return $this->hasMany(DoctorBranch::class)->withTranslation();
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\DoctorRating')->orderBy('updated_at', 'desc');
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
    public function user_entry()
    {
        return $this->belongsTo('App\Models\User', 'user_entry_id', 'id');
    }

    public function getAddressAttribute()
    {
        return $this->hasMany(DoctorBranch::class)->withTranslation();
    }

}
