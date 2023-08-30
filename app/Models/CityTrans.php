<?php

namespace App\Models;

use App\Models\BaseModel;

class CityTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
    ];
}
