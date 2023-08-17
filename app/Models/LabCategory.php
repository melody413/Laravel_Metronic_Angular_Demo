<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class LabCategory extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\LabCategoryTrans';

    public $translatedAttributes = [
        'name',
        'excerpt',
        'description'
    ];

    public $fillable = [
        'image',
        'is_active',
        // 'user_id',
        // 'body_parts_ids',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('lab_categories.*');
        $query->addSelect('lab_category_trans.name as name');
        $query->join('lab_category_trans', 'lab_category_id', '=', 'lab_categories.id');
        $query->where('lab_category_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }


}
