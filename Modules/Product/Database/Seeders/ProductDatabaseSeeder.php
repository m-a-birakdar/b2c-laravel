<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductDetails;

class ProductDatabaseSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->count(100)->has(ProductDetails::factory(), 'details')->create();
    }
}
