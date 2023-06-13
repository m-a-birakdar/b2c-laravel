<?php

namespace Modules\Chat\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Chat\Entities\Chat;

class ChatDatabaseSeeder extends Seeder
{
    public function run()
    {
        Chat::factory()->count(10)->create();
    }
}
