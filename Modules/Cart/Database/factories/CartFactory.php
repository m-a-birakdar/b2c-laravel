<?php

namespace Modules\Cart\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = \Modules\Cart\Entities\Cart::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

