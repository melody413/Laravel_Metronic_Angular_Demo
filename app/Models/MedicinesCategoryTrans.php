<?php

namespace App\Models;

use App\Models\BaseModel;

class MedicinesCategoryTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
    ];
}
