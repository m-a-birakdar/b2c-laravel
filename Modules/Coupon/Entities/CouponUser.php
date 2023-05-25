<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    protected $table = 'coupon_user';

    public $timestamps = false;

    protected $fillable = ['coupon_id', 'user_id', 'times_used'];
}
