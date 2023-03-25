<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\SubCategory;

class CategoryDatabaseSeeder extends Seeder
{
    public function run()
    {
        Category::factory()->count(3)->has(SubCategory::factory()->count(3), 'subCategories')->create();
    }
}
