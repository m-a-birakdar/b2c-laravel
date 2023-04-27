<?php

namespace Modules\Address\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Address\Entities\Address;

class AddressDatabaseSeeder extends Seeder
{
    public function run()
    {
        Address::factory()->count(10)->create();
    }
}
