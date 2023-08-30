<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Symptom extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\SymptomTrans';

    public $translatedAttributes = [
        'name',
        'excerpt',
        'description'
    ];

    public $fillable = [
        'image',
        'is_active',
        // 'user_id',
        'body_parts_ids',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('symptoms.*');
        $query->addSelect('symptom_trans.name as name');
        $query->join('symptom_trans', 'symptom_id', '=', 'symptoms.id');
        $query->where('symptom_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }


}
