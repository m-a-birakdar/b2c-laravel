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
        for ($i = 0; $i < 3; $i++){
            for ($j = 0; $j < 10; $j++){
                Http::withToken($token)->acceptJson()->get('http://bar.tenant.local/cu-api/v1/carts/add/' . rand(1,10));
            }
            Http::withToken($token)->acceptJson()->post('http://bar.tenant.local/cu-api/v1/orders/save', [
                'address_id' => 1,
                'payment_method' => 1,
            ]);
        }
    }
}
