<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class MedicinesCategory extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\MedicinesCategoryTrans';

    public $translatedAttributes = [
        'name'
    ];

    public $fillable = [
        'name',
        'parent',
        'city_id',
        'area_id',
        'country_id',
        'is_active',
        'user_id',
    ];

    public function medicine_categories()
    {
        return $this->belongsToMany('App\Models\MedicinesCategory', 'tag_medicine_category');
    }

    public function scopeSearch($query, $search)
    {
        $query->select('medicines_categories.*');
        // $query->addSelect('medicines_category_trans.name as name');
        // $query->join('medicines_category_trans', 'medicines_category_id', '=', 'medicines_categories.id');
        // $query->where('medicines_category_trans.locale', '=', 'ar');

        return $query->where('id', 'LIKE', "%$search%");
    }

    public function city()
    {
        return $this->hasOne('App\Models\City', 'id', 'city_id')->withTranslation();
    }

    public function area()
    {
        return $this->hasOne('App\Models\Area', 'id', 'area_id')->withTranslation();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
