<?php

namespace App\Models;

use App\Models\BaseModel;

class DiseaseTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
        'symptoms',
        'causes',
        'complications',
        'diagnosis',
        'treatment',
        'protection',
        'alternative_therapies',
    ];
}
