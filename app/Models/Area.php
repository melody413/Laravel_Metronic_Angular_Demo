<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Area extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\AreaTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $fillable = [
        'city_id',
        'is_active',
    ];

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id')->withTranslation();
    }
}
