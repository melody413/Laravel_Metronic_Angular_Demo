<?php

namespace App\Models;

use App\Models\BaseModel;

class MedicineTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'name',
        'excerpt',
        'description',
        'breastfeedingWarning',
        'clinicalPharmacology',
        'foodWarning',
        'mechanismOfAction',
        'overdosage',
        'pregnancyWarning',
        'prescriptionStatus'
    ];
}
