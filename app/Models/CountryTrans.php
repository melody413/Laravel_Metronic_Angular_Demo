<?php

namespace App\Models;

use App\Models\BaseModel;

class CountryTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        ];
}
