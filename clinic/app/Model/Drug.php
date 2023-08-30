<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    public function prescriptions()
    {
        return $this->hasMany(PrescriptionDrug::class,'drug_id');
    }

    public function templates()
    {
        return $this->hasMany(PrescriptionTemplateDrug::class);
    }
}
