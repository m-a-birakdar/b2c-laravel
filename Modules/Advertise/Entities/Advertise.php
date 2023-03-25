<?php

namespace Modules\Advertise\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advertise extends Model
{
    use HasFactory;

    protected $table = 'advertises';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Advertise\Database\factories\AdvertiseFactory
    {
        return \Modules\Advertise\Database\factories\AdvertiseFactory::new();
    }
}
