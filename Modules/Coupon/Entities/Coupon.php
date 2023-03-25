<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $fillable = ["name"];

    protected $casts = [];

    protected static function newFactory(): \Modules\Coupon\Database\factories\CouponFactory
    {
        return \Modules\Coupon\Database\factories\CouponFactory::new();
    }
}
