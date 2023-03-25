<?php

namespace Modules\Currency\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Currency\Database\factories\CurrencyFactory
    {
        return \Modules\Currency\Database\factories\CurrencyFactory::new();
    }
}
