<?php

namespace App\Models;

use App\Models\BaseModel;

class MedicinesScNameTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
    ];
}
