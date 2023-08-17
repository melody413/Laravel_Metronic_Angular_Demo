<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PatientAppointment extends Model
{
    protected $dates=[
      'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Appointment::class,'appointment_id');
    }

    public function payment()
    {
        return $this->hasOne(PatientPayment::class,'patient_appointment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
