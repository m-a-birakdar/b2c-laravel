<?php

namespace Modules\Support\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupportFactory extends Factory
{
    protected $model = \Modules\Support\Entities\Support::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

