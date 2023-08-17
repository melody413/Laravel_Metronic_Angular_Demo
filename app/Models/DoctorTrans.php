<?php

namespace App\Models;

use App\Models\BaseModel;

class DoctorTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'title',
        'excerpt',
        'description',
    ];
}
