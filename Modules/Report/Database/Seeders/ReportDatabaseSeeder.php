<?php

namespace Modules\Report\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Report\Entities\Report;

class ReportDatabaseSeeder extends Seeder
{
    public function run()
    {
        Report::factory()->count(10)->create();
    }
}
