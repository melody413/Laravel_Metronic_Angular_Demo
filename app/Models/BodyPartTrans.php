<?php

namespace App\Models;

use App\Models\BaseModel;

class BodyPartTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
    ];
}
