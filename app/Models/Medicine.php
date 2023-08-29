<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Medicine extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\MedicineTrans';

    public $translatedAttributes = [
        'name',
        'excerpt',
        'description',
        'breastfeedingWarning',
        'clinicalPharmacology',
        'foodWarning',
        'mechanismOfAction',
        'overdosage',
        'pregnancyWarning',
        'prescriptionStatus'
    ];

    public $fillable = [
        'category',
        'category_2',
        'category_3',
        'body_part_ids',
        'symptom_ids',
        'type',
        'disease',
        'disease_ar',
        'disease_2',
        'disease_2_ar',
        'disease_3',
        'disease_3_ar',
        'conc_type',
        'side_effects_ar',
        'image',
        'name',
        'trade_name',
        'country_id',
        'concentration',
        'concentration_2',
        'concentration_3',
        'suspensie',
        'form',
        'quantity',
        'price',
        'sa_price',
        'dose',
        'dose_ar',
        'company',
        'scientific_name_1',
        'scientific_name_2',
        'scientific_name_3',
        'made_in',
        'side_effects',
        'is_active',
        'show_all',
        'user_id',
        'warning',
        'interactions',
        'warning_ar',
        'interactions_ar',
        'activeIngredient',
        'maximumIntake',
        'strengthUnit',
        'doseUnit',
        'frequency',
        'targetPopulation',
        'max_doseUnit',
        'max_doseValue',
        'max_frequency',
        'max_targetPopulation',
    ];

    public function scopeSearch($query, $search)
    {
        $query->select('medicines.*');
        $query->addSelect('medicine_trans.name as name');
        $query->join('medicine_trans', 'medicine_id', '=', 'medicines.id');
        $query->where('medicine_trans.locale', '=', 'ar');

        return $query->where('medicines_category_trans.name', 'LIKE', "%$search%");
    }

    public function specialties()
    {
        return $this->belongsToMany('App\Models\Specialty');
    }

    public function doctors()
    {
        return $this->belongsToMany('App\Models\Doctor');
    }

    public function getDoctors()
    {
        return $this->doctors()->where('is_active',1)->orderBy('id','DESC')->get();
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
