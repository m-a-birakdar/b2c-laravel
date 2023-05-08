<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Currency\Entities\Currency;

class CurrencyDatabaseSeeder extends Seeder
{
    public function run()
    {
        Currency::create([
            'name' => 'Turkish Lira', 'key' => 'tr', 'value' => 19.4
        ]);
    }
}
