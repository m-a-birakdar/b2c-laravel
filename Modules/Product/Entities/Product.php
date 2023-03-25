<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Product\Database\factories\ProductFactory
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
