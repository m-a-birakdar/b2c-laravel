<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;

class ProductDatabaseSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->count(10)->create();
    }
}
