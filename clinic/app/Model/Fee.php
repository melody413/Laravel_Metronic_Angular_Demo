<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\FeeDetail;

class Fee extends Model
{
    public function feesDetails()
    {
        return $this->hasMany(FeeDetail::class);
    }
}
