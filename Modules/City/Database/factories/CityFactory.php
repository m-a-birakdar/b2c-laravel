<?php

namespace Modules\City\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = \Modules\City\Entities\City::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

