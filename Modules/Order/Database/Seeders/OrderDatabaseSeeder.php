<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Modules\Order\Entities\Order;
use Stancl\Tenancy\Database\Models\Tenant;

class OrderDatabaseSeeder extends Seeder
{
    public function run()
    {
        $token = file_get_contents(base_path('storage/tenantbar/app/token.txt'));
        $token = explode('Customer ', $token);
        $token = str_replace("\r\n", '', $token[1]);
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/3');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/3');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/3');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/2');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/2');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/1');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/add/5');
        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/carts/checkout');
//        $response = Http::withToken($token)->withHeaders(['Accept' => 'application/json'])->get('http://bar.tenant.local/cu-api/v1/orders/save');
    }
}
