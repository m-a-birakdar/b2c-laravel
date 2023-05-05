<?php

namespace Modules\Wallet\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Wallet\Entities\Card;
use Modules\Wallet\Entities\Wallet;

class WalletDatabaseSeeder extends Seeder
{
    public function run()
    {
        Card::factory()->count(100)->create();
    }
}
