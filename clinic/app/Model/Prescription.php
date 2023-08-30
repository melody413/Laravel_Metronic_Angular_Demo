<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\PrescriptionDrug;
use App\Model\PrescriptionLeft;

use App\User;

class Prescription extends Model
{
    protected $dates = [
      'prescription_date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function drugs()
    {
        return $this->hasMany(PrescriptionDrug::class)->with('drug');
    }

    public function prescriptionLeft()
    {
        return $this->hasOne(PrescriptionLeft::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(PrescriptionTemplate::class,'prescription_template_id');
    }
}
