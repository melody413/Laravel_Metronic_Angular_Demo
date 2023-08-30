<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class BodyPart extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\BodyPartTrans';

    public $translatedAttributes = [
        'name',
        'excerpt',
        'description',
    ];

    public $fillable = [
        'image',
        'country_id',
        'parent',
        'is_active',
        'user_id',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('body_parts.*');
        $query->addSelect('body_part_trans.name as name');
        $query->join('body_part_trans', 'body_part_id', '=', 'body_parts.id');
        $query->where('body_part_trans.locale', '=', 'ar');
        dd($query);
        return $query->where('name', 'LIKE', "%$search%");
    }

}
