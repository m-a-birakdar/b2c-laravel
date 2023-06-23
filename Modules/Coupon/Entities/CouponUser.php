<?php

namespace Modules\Coupon\Entities;

use App\Models\OverrideModel;

class CouponUser extends OverrideModel
{
    protected $table = 'coupon_user';

    public $timestamps = false;

    protected $fillable = ['coupon_id', 'user_id', 'times_used'];
}
