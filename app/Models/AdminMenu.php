<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    public $fillable = [
        'icon',
        'title',
        'url',
        'in_menu',
        'in_permission',
        'parent_id',
        'display_order',
        'controller',
        'action',
        'params',
        'route_name',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\AdminMenu', 'parent_id');
    }

    public function sub_menus()
    {
        return $this->hasMany('App\Models\AdminMenu', 'parent_id');
    }

    public function getActiveSubMenus()
    {
        return $this->sub_menus()->where('is_active', 1)->where('in_menu', 1)->get();
    }

}
