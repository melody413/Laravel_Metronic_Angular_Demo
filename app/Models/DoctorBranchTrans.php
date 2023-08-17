<?php

namespace App\Models;

use App\Models\BaseModel;

class DoctorBranchTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'address',
    ];
}
