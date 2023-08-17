<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class DoctorBranch extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\DoctorBranchTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $table = 'doctor_branches';

    public $fillable = [
        'doctor_id',
        'day_of_week',
        'time_start',
        'time_end',
        'patient_every',
        'price',
        'phone',
        'country_id',
        'city_id',
        'area_id',
        'lat_lng',
        'is_active',
    ];


    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id')->withTranslation();
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id')->orderBy('updated_at', 'desc')->withTranslation();
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area_id')->orderBy('updated_at', 'desc')->withTranslation();
    }


}
