<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class HospitalType extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\HospitalTypeTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $fillable = [
        'is_active',
    ];



}
