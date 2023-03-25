<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Order\Entities\Order;

class OrderDatabaseSeeder extends Seeder
{
    public function run()
    {
        Order::factory()->count(10)->create();
    }
}
