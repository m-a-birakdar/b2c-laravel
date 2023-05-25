<?php

namespace Modules\Coupon\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Coupon\Entities\Coupon;

class CouponDatabaseSeeder extends Seeder
{
    public function run()
    {
        Coupon::factory()->count(1)->create();
    }
}
