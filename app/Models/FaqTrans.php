<?php

namespace App\Models;

use App\Models\BaseModel;

class FaqTrans extends BaseModel
{
    public $timestamps = false;
    public $fillable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];
}
