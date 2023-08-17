<?php

namespace App\Models;

use App\Models\BaseModel;

class DoctorReservation extends BaseModel
{

    public $fillable = [
        'name',
        'email',
        'phone',
        'reserve_time',
        'reserve_date',
        'doctor_id',
        'user_id',
    ];

    public function doctor()
    {
        return $this->hasOne('App\Models\Doctor', 'id', 'doctor_id')->withTranslation();
    }

    public function branch()
    {
        return $this->hasOne('App\Models\DoctorBranch', 'id', 'doctor_branch_id')->withTranslation();
    }
}
