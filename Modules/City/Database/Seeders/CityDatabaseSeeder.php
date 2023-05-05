<?php

namespace Modules\City\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\City\Entities\City;

class CityDatabaseSeeder extends Seeder
{
    public function run()
    {
        City::insert([
            ['name' => 'Istanbul', 'slug' => 'istanbul'],
            ['name' => 'Bursa', 'slug' => 'bursa'],
        ]);
    }
}
