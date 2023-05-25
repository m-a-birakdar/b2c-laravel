<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'usage_limit', 'usage_per_customer', 'times_used', 'expired_at', 'usage_count', 'type', 'value'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_user')->withPivot('times_used');
    }

    protected static function newFactory(): \Modules\Coupon\Database\factories\CouponFactory
    {
        return \Modules\Coupon\Database\factories\CouponFactory::new();
    }
}
