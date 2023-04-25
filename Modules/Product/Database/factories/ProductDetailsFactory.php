<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductDetailsFactory extends Factory
{
    protected $model = \Modules\Product\Entities\ProductDetails::class;

    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence,
            'quantity' => $this->faker->numberBetween(100,1000),
        ];
    }
}

