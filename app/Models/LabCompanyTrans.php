<?php

namespace App\Models;

use App\Models\BaseModel;

class LabCompanyTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
    ];
}
