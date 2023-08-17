<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\PrescriptionLeft;
use App\Model\PrescriptionTemplateDrug;

use App\User;

class PrescriptionTemplate extends Model
{
    public function drugs()
    {
        return $this->hasMany(PrescriptionTemplateDrug::class)->with('drug');
    }

    public function prescriptionTemplateLeft()
    {
        return $this->hasOne(PrescriptionTemplateLeft::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
