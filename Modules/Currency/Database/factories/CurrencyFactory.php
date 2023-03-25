<?php

namespace Modules\Currency\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = \Modules\Currency\Entities\Currency::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

