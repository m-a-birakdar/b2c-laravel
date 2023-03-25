<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Order\Database\factories\OrderFactory
    {
        return \Modules\Order\Database\factories\OrderFactory::new();
    }
}
