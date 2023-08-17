<?php

namespace App\Models;

use App\Scopes\CountryScope;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class BaseModel extends Model
{
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $historyLimit = 500;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function boot(){
        parent::boot();
        static::addGlobalScope(new CountryScope());
    }

    public function update(array $attributes = [], array $options = [])
    {
        parent::update($attributes, $options);
        $this->saveIsActiveColumn($attributes, $options);
    }

    public function saveIsActiveColumn($attributes = [], $options)
    {
        //dd($attributes, in_array('is_active', $attributes));

        if ( !empty($attributes) && in_array('is_active', $this->fillable) && ! isset($attributes['is_active']))
        {
            //dd( in_array('is_active', $attributes) );
            $this->is_active = 0 ;
            $this->save();
        }



    }

    public function getPhonesAttribute()
    {
        return explode('/', $this->phone);
    }


    public static function getIsActive()
    {
        return self::where('is_active',1);
    }


}
