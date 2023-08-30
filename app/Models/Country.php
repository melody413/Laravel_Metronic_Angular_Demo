<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Country extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\CountryTrans';

    public $translatedAttributes = [
        'name'
    ];

    public const AVAILABLE_COUNTRIES = [
        'eg'=>[
            'id'=>4,
            ],
        'ksa'=>[
            'id'=>5,
        ]
    ];

    public $fillable = [
        'image',
        'code',
        'currency_code',
        'is_active',
    ];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }


}
