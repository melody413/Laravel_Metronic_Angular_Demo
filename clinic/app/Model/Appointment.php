<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $dates =[
      'date'
    ];

    public function dateTime()
    {
        return $this->hasMany(AppointmentDateTime::class);
    }

    public function patientAppointments()
    {
        return $this->hasMany(PatientAppointment::class);
    }


}
