<?php

namespace Modules\Advertise\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Advertise\Entities\Advertise;

class AdvertiseDatabaseSeeder extends Seeder
{
    public function run()
    {
        Advertise::factory()->count(10)->create();
    }
}
