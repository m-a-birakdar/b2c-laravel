<?php

namespace Modules\Tenant\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = \Modules\Tenant\Entities\Tenant::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

