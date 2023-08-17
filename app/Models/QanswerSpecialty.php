<?php

namespace App\Models;

use App\Models\BaseModel;

class QanswerSpecialty extends BaseModel
{
    protected $table = 'qanswer_specialty';
    public $timestamps = false;
    public $fillable = [
        'qanswer_id',
        'specialty_id',
    ];
}
