<?php

namespace Modules\Shipment\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    protected $model = \Modules\Shipment\Entities\Shipment::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

