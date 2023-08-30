<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrescriptionTemplateDrug extends Model
{
    public function drug()
    {
        return $this->belongsTo(Drug::class,'drug_id');
    }
}
