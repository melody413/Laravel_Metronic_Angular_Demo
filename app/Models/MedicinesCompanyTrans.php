<?php

namespace App\Models;

use App\Models\BaseModel;

class MedicinesCompanyTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
    ];
}
