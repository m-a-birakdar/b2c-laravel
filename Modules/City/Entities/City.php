<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = ['name', 'slug', 'status'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->slug = Str::slug($model->name);
        });
    }
}
