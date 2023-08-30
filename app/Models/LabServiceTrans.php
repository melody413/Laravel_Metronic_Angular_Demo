<?php

namespace App\Models;

use App\Models\BaseModel;

class LabServiceTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'sample',
        'measruing_unit',
        'measruing_unit_female',
        'normal_range',
        'about_test',
        'used_to',
        'reasons_for',
        'how_is',
        'how_prepare',
        'risks',
        'interpretation_result',
        'reasons_high_reading',
        'references',
    ];
}
