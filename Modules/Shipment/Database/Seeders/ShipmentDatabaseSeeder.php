<?php

namespace Modules\Shipment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shipment\Entities\Shipment;

class ShipmentDatabaseSeeder extends Seeder
{
    public function run()
    {
        Shipment::factory()->count(10)->create();
    }
}
