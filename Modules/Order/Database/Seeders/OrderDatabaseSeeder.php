<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Modules\Order\Entities\Order;

class OrderDatabaseSeeder extends Seeder
{
    public function run()
    {
        $token = '3|YZXJDQdDgPU4gF1PuNw6aanDUvPYOvSk6x7RvE9Y';
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/3');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/3');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/3');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/2');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/2');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/1');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/5');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/checkout');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/orders/save');
    }
}
