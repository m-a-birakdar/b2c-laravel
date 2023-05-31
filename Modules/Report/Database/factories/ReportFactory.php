<?php

namespace Modules\Report\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = \Modules\Report\Entities\Report::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

