<?php

namespace App\Models;

use App\Models\BaseModel;

class PharmacyCompanyTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
    ];
}
