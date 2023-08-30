<?php

namespace App\Models;

use App\Models\BaseModel;

class QanswerMedicineCategory extends BaseModel
{
    protected $table = 'qanswer_medicine_category';
    public $timestamps = false;
    public $fillable = [
        'qanswer_id',
        'medicines_category_id',
    ];
}
