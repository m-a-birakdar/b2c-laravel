<?php

namespace Modules\Advertise\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertiseFactory extends Factory
{
    protected $model = \Modules\Advertise\Entities\Advertise::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

