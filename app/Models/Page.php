<?php

namespace App\Models;

use App\Models\BaseModel;
use Astrotomic\Translatable\Translatable;

class Page extends BaseModel
{
    use Translatable;

    public $translationModel = 'App\Models\PageTrans';

    public $translatedAttributes = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    public $fillable = [
        'slug',
        'image',
        'is_active'
    ];


}
