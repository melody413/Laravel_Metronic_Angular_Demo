<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class City extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\CityTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $fillable = [
        'country_id',
        'is_active',
    ];

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id')->withTranslation();
    }



}
