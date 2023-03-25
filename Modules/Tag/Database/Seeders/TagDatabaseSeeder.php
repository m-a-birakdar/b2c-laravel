<?php

namespace Modules\Tag\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Tag\Entities\Tag;

class TagDatabaseSeeder extends Seeder
{
    public function run()
    {
        Tag::factory()->count(10)->create();
    }
}
