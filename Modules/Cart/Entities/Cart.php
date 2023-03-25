<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Cart\Database\factories\CartFactory
    {
        return \Modules\Cart\Database\factories\CartFactory::new();
    }
}
