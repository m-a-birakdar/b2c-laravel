<?php

namespace Modules\Cart\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Cart\Entities\Cart;

class CartDatabaseSeeder extends Seeder
{
    public function run()
    {
        Cart::factory()->count(10)->create();
    }
}
