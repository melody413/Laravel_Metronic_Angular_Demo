<?php

namespace App\Models;

use App\Models\BaseModel;

class HospitalTypeTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
    ];
}
