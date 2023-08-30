<?php

namespace App\Models;

use App\Models\BaseModel;

class DoctorRating extends BaseModel
{

    public $fillable = [
        'rate',
        'comment',
        'doctor_id',
        'user_id',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
