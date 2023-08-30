<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class MedicinesCompany extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\MedicinesCompanyTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $fillable = [
        'name',
        'phone',
        'image',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'website',
        'city_id',
        'area_id',
        'country_id',
        'is_active',
        'user_id',
    ];

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
