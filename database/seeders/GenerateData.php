<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\User\Repositories\CuApi\V1\AuthRepository;

class GenerateData extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++){
            $user = ( new AuthRepository() )->welcome([
                'fcm_token' => Str::random(100),
                'device_info' => '',
            ]);
            $token = $user->createToken(Str::random(20))->plainTextToken;
            for ($i = 0; $i < 10; $i++){
                for ($j = 0; $j < 10; $j++)
                    Http::withToken($token)->acceptJson()->get('http://bar.tenant.local/cu-api/v1/carts/add/' . rand(1, 100));
                Http::withToken($token)->acceptJson()->post('http://bar.tenant.local/cu-api/v1/orders/save', [
                    'address_id' => 1,
                    'payment_method' => 1,
                ]);
            }
        }
    }
}
