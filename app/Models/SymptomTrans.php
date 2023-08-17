<?php

namespace App\Models;

use App\Models\BaseModel;

class SymptomTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
    ];
}
