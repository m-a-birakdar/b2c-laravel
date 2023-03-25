<?php

namespace Modules\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tenant\Entities\Tenant;

class TenantDatabaseSeeder extends Seeder
{
    public function run()
    {
        Tenant::factory()->count(10)->create();
    }
}
