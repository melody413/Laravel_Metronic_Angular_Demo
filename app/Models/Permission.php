<?php

namespace App\Models;

use App\Models\BaseModel;

class Permission extends BaseModel
{
    public $fillable = [
        'name',
        'label'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
