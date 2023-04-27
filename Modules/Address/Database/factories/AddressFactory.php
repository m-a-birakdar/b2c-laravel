<?php

namespace Modules\Address\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = \Modules\Address\Entities\Address::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

