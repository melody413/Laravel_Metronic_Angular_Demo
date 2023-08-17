<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Specialty extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\SpecialtyTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $fillable = [
        'is_active',
    ];



}
