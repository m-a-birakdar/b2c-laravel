<?php

namespace Modules\Tag\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = \Modules\Tag\Entities\Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

