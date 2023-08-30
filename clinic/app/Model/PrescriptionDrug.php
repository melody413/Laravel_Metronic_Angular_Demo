<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PrescriptionDrug extends Model
{
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
