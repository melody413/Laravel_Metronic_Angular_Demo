<?php

namespace App\Models;

use App\Models\BaseModel;

class HospitalTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
        'address',
    ];
}
