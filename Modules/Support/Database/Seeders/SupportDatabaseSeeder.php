<?php

namespace Modules\Support\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Support\Entities\Support;

class SupportDatabaseSeeder extends Seeder
{
    public function run()
    {
        Support::factory()->count(10)->create();
    }
}
