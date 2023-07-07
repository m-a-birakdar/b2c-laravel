<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Sanctum\Sanctum;
use Modules\Cart\Repositories\CuApi\V1\CartRepository;
use Modules\Order\Http\Requests\CuApi\V1\OrderRequest;
use Modules\Order\Repositories\CuApi\V1\OrderRepository;
use Modules\User\Entities\User;

class OrderDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(3);
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
}
