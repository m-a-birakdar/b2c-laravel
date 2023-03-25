<?php

namespace Modules\Order\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = \Modules\Order\Entities\Order::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

