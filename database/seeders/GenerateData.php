<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Modules\Cart\Repositories\CuApi\V1\CartRepository;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;
use Modules\Order\Repositories\CuApi\V1\OrderRepository;
use Modules\Product\Entities\Product;
use Jenssegers\Mongodb\Collection as MongoCollection;
use Modules\Product\Entities\ProductStatistics;
use Modules\Product\Enums\StatisticsEnum;
use Modules\Report\Entities\ProductReport;
use Modules\User\Entities\User;
use Modules\User\Entities\UserDetails;
use Modules\User\Repositories\CuApi\V1\AuthRepository;

class GenerateData extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        for ($i = 0; $i < 10; $i++){
            $user = ( new AuthRepository() )->welcome([
                'fcm_token' => Str::random(100),
                'device_info' => '',
            ]);
            Sanctum::actingAs($user);
            echo $user->id . PHP_EOL;
            for ($i = 0; $i < 10; $i++){
                for ($j = 0; $j < 10; $j++)
                    ( new CartRepository )->add(rand(1,10));
                $request = new OrderRequest([
                    'address_id' => 1,
                    'payment_method' => 1,
                ]);
                $request->passedValidation();
                ( new OrderRepository() )->save($request);
            }
        }
        $startDate = Carbon::now()->subYear()->startOfYear();
        $endDate = Carbon::now()->subDay()->startOfDay();
        $orders = Order::query()->get(['id', 'created_at']);
        foreach ($orders as $order) {
            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d H:i:s');
            $order->update([
                'created_at' => $randomDate
            ]);
            echo $order->id . PHP_EOL;
        }
        $users = User::query()->get(['id', 'created_at']);
        foreach ($users as $user) {
            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d H:i:s');
            $user->update([
                'created_at' => $randomDate
            ]);
            echo $user->id . PHP_EOL;
        }
        $users = UserDetails::query()->get(['id', 'last_active_at']);
        foreach ($users as $user) {
            $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp))->format('Y-m-d H:i:s');
            $user->update([
                'last_active_at' => $randomDate
            ]);
            echo $user->id . PHP_EOL;
        }
        foreach (Product::all(['id']) as $item) {
            ProductReport::query()->create([
                'id' => $item->id
            ]);
        }
        for ($i = 1; $i < 8; $i++){
            Process::run('php artisan tenants:run report:save --argument="type=d" --option="sub=' . $i .'"');
        }
        for ($i = 1; $i < 7; $i++){
            Process::run('php artisan tenants:run report:save --argument="type=w" --option="sub=' . $i .'"');
        }
        for ($i = 1; $i < 5; $i++){
            Process::run('php artisan tenants:run report:save --argument="type=m" --option="sub=' . $i .'"');
        }
        Process::run('php artisan tenants:run report:save --argument="type=y"');
        User::query()->select(['id'])->chunkById(100, function ($users){
            foreach ($users as $user) {
                $data = [];
                for ($i = 0; $i < 200; $i++){
                    $data[] = [
                        'product_id' => rand(1, 100), 'user_id' => (int) $user->id, 'type' => rand(1,6)
                    ];
                }
                ProductStatistics::query()->insert($data);
                echo $user->id . PHP_EOL;
            }
        });



//        $mostShownProducts = ProductStatistics::raw(function ($collection) {
//            return $collection->aggregate([
//                [
//                    '$match' => [
//                        'user_id' => 12,
//                        'type' => StatisticsEnum::RemoveFromFavorite->value
//                    ]
//                ],
//                [
//                    '$group' => [
//                        '_id' => '$product_id',
//                        'show_count' => ['$sum' => 1]
//                    ]
//                ],
//                [
//                    '$sort' => [
//                        'show_count' => -1 // Sort in descending order by show_count
//                    ]
//                ],
//                [
//                    '$limit' => 2 // Limit the result to 1 document
//                ]
//            ]);
//        });
//
//// Output the results
//        foreach ($mostShownProducts as $product) {
//            echo "Product ID: " . $product->_id . ", Show Count: " . $product->show_count . "\n";
//        }
    }
}
