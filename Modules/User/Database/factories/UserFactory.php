<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = \Modules\User\Entities\User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

