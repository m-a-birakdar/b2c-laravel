<?php

namespace Modules\Notification\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = \Modules\Notification\Entities\Notification::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

