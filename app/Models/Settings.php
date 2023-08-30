<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Settings extends BaseModel
{

    public $fillable = [
        'key',
        'value',
        'auto_load'
    ];


}
