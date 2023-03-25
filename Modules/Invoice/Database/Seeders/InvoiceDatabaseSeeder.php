<?php

namespace Modules\Invoice\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Invoice\Entities\Invoice;

class InvoiceDatabaseSeeder extends Seeder
{
    public function run()
    {
        Invoice::factory()->count(10)->create();
    }
}
