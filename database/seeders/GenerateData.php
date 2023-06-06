<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Order\Entities\Order;
use Modules\User\Entities\User;
use Modules\User\Entities\UserDetails;
use Modules\User\Repositories\CuApi\V1\AuthRepository;

class GenerateData extends Seeder
{
    public function run(): void
    {
//        for ($i = 0; $i < 1000; $i++){
//            $user = ( new AuthRepository() )->welcome([
//                'fcm_token' => Str::random(100),
//                'device_info' => '',
//            ]);
//            $token = $user->createToken(Str::random(20))->plainTextToken;
//            for ($i = 0; $i < 10; $i++){
//                for ($j = 0; $j < 10; $j++)
//                    Http::withToken($token)->acceptJson()->get('http://bar.tenant.local/cu-api/v1/carts/add/' . rand(1, 100));
//                Http::withToken($token)->acceptJson()->post('http://bar.tenant.local/cu-api/v1/orders/save', [
//                    'address_id' => 1,
//                    'payment_method' => 1,
//                ]);
//            }
//        }
        $startDate = Carbon::now()->subYear()->startOfYear();
        $endDate = Carbon::now()->subDay()->startOfDay();
//        $orders = Order::query()->get(['id', 'created_at']);
//        foreach ($orders as $order) {
//            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d H:i:s');
//            $order->update([
//                'created_at' => $randomDate
//            ]);
//            echo $order->id . PHP_EOL;
//        }
//        $users = User::query()->get(['id', 'created_at']);
//        foreach ($users as $user) {
//            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d H:i:s');
//            $user->update([
//                'created_at' => $randomDate
//            ]);
//            echo $user->id . PHP_EOL;
//        }
//        $users = UserDetails::query()->get(['id', 'last_active_at', 'created_at']);
//        foreach ($users as $user) {
//            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d H:i:s');
//            $user->update([
//                'last_active_at' => $randomDate
//            ]);
//            echo $user->id . PHP_EOL;
//        }
    }
}
