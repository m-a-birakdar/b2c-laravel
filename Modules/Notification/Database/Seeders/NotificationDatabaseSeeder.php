<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\Entities\Notification;

class NotificationDatabaseSeeder extends Seeder
{
    public function run()
    {
        Notification::factory()->count(10)->create();
    }
}
