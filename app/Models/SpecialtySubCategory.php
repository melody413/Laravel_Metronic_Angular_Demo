<?php

namespace App\Models;

use App\Models\BaseModel;

class SpecialtySubCategory extends BaseModel
{
    protected $table = 'specialty_sub_category';
    public $timestamps = false;
    public $fillable = [
        'name',
    ];
}
