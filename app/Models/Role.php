<?php

namespace App\Models;

use App\Models\BaseModel;

class Role extends BaseModel
{
    protected $table = 'roles';
    public $fillable = [
        'name',
        'label'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    public function getAllRoles(){
        return self::all();
    }
}
