<?php

namespace Modules\Coupon\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = \Modules\Coupon\Entities\Coupon::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->postcode,
            'usage_limit' => 10,
            'usage_count' => 10,
            'type' => 1,
            'value' => 10,
            'usage_per_customer' => 1,
            'expired_at' => now()->addHour(),
        ];
    }
}

