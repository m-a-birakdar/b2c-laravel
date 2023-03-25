<?php

namespace Modules\Invoice\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = \Modules\Invoice\Entities\Invoice::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

