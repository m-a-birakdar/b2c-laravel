<?php

namespace Modules\Chat\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    protected $model = \Modules\Chat\Entities\Chat::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

