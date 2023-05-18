<?php

namespace Database\Seeders;

use App\Events\SendMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Modules\Category\Database\Seeders\CategoryDatabaseSeeder;
use Modules\City\Database\Seeders\CityDatabaseSeeder;
use Modules\Currency\Database\Seeders\CurrencyDatabaseSeeder;
use Modules\Order\Database\Seeders\OrderDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Tenant\Database\Seeders\TenantDatabaseSeeder;
use Modules\User\Database\Seeders\RoleTableSeeder;
use Modules\User\Database\Seeders\UserDatabaseSeeder;
use ElephantIO\Client;
use Modules\Wallet\Database\Seeders\WalletDatabaseSeeder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
//        QrCode::backgroundColor(0, 255, 0, 0)->color(255,255,255)->eye('circle')->size(100)->format('png')->generate('Your QR code data', public_path('qr.png'));

        // create Image from file
        $img = Image::make(public_path('123.png'));
        $img2 = Image::make(public_path('user.jpg'))->resize(200, 200)->encode('png')->save(public_path('user-1.png'));
        $img3 = Image::make(public_path('user-1.png'));
// use callback to define details
        $img->text('Amer', 0, 140, function($font) {
            $font->file(public_path('Cairo-Regular.ttf'));
            $font->size(60);
            $font->color('#750000');
        });
        $img->insert($img3, 'bottom-right', 10, 10);
        $img->save(public_path('new.png'));
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
//        $this->call(CityDatabaseSeeder::class);
//        $this->call(RoleTableSeeder::class);
//        $this->call(UserDatabaseSeeder::class);
//        $this->call(CategoryDatabaseSeeder::class);
//        $this->call(ProductDatabaseSeeder::class);
//        $this->call(WalletDatabaseSeeder::class);
//        $this->call(CurrencyDatabaseSeeder::class);
//        $this->call(OrderDatabaseSeeder::class);
//        $this->call(TenantDatabaseSeeder::class);
    }
}
