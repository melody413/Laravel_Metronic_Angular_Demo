<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class LabService extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\LabServiceTrans';

    public $translatedAttributes = [
        'name',
        'sample',
        'measruing_unit',
        'measruing_unit_female',
        'normal_range',
        'about_test',
        'used_to',
        'reasons_for',
        'how_is',
        'how_prepare',
        'risks',
        'interpretation_result',
        'reasons_high_reading',
        'references',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('lab_services.*');
        $query->addSelect('lab_service_trans.name as name');
        $query->join('lab_service_trans', 'lab_service_id', '=', 'lab_services.id');
        $query->where('lab_service_trans.locale', '=', 'ar');

        return $query->where('name', 'LIKE', "%$search%");
    }
    
    public $fillable = [
        'id',
        'lab_category',
        'image'
    ];

    public function lab()
    {
        return $this->belongsToMany('App\Models\Lab', 'labs');
    }


}
