<?php

namespace Modules\Coupon\Entities;

use App\Models\OverrideModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

/**
 * @property mixed $usage_per_customer
 * @property mixed $id
 * @property mixed $usage_limit
 * @property mixed $usage_count
 * @property mixed $times_used
 * @property mixed $expired_at
 * @property mixed $value
 * @property mixed $type
 */

class Coupon extends OverrideModel
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
