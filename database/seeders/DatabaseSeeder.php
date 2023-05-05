<?php

namespace Database\Seeders;

use App\Events\SendMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Tenant\Database\Seeders\TenantDatabaseSeeder;
use Modules\User\Database\Seeders\RoleTableSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;
use ElephantIO\Client;
use Modules\Wallet\Database\Seeders\WalletDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
//        $client = new Client(Client::engine(Client::CLIENT_4X, 'http://localhost:6001'));
//        try {
//            $client->initialize();
////            $client->emit('new_chat', ['user1_id' => rand(1,100), 'user2_id' => rand(1,100), ]);
//            $client->emit('receive_message', ['sender_id' => rand(1,100), 'chat_id' => rand(1,100), 'text' => Str::random(100)]);
//            echo 'Done' . PHP_EOL;
////            $client->emit('start_end_connection', [
////                'user_id' => 12122, 'status' => 'start'
////            ]);
////            $client->emit('start_end_connection', [
////                'user_id' => 12122, 'status' => 'end'
////            ]);
//            $client->close();
//        } catch (\Exception $exception){
//            echo $exception;
//            $client->close();
//        }
        $this->call(CityDatabaseSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserDatabaseSeeder::class);
        $this->call(CategoryDatabaseSeeder::class);
        $this->call(ProductDatabaseSeeder::class);
        $this->call(WalletDatabaseSeeder::class);
//        $this->call(TenantDatabaseSeeder::class);
    }
}
