<?php

namespace Modules\Wallet\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = \Modules\Wallet\Entities\Wallet::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}

