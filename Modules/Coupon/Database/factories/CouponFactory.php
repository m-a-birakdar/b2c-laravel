<?php

namespace Modules\Coupon\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = \Modules\Coupon\Entities\Coupon::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

