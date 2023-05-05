<?php

namespace Modules\Wallet\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = \Modules\Wallet\Entities\Card::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->creditCardNumber,
            'cvv' => $this->faker->numberBetween(100, 999),
            'value' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}

