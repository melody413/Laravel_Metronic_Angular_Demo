<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class LabCompany extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\LabCompanyTrans';

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
        $query->select('lab_companies.*');
        $query->addSelect('lab_company_trans.name as name');
        $query->join('lab_company_trans', 'lab_company_id', '=', 'lab_companies.id');
        $query->where('lab_company_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }


}
