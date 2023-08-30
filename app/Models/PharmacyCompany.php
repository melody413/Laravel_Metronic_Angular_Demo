<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class PharmacyCompany extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\PharmacyCompanyTrans';

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
        $query->select('pharmacy_companies.*');
        $query->addSelect('pharmacy_company_trans.name as name');
        $query->join('pharmacy_company_trans', 'pharmacy_company_id', '=', 'pharmacy_companies.id');
        $query->where('pharmacy_company_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }


}
