<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class OrderDatabaseSeeder extends Seeder
{
    private string $token;

    public function run(): void
    {
        $token = file_get_contents(base_path('storage/tenantbar/app/token.txt'));
        $token = explode('Customer ', $token);
        $this->token = str_replace("\r\n", '', $token[1]);
        for ($i = 0; $i < 3; $i++){
            for ($j = 0; $j < 10; $j++)
                $this->request('http://bar.tenant.local/cu-api/v1/carts/add/' . rand(1,10));
            $this->request('http://bar.tenant.local/cu-api/v1/orders/save', 'POST', [
                'address_id' => 1,
                'payment_method' => 1,
            ]);
        }
    }

    private function request(string $uri, string $method = 'GET', array $parameters = []): void
    {
        $req = Request::create($uri, $method, $parameters);
        $req->header('Authorization', 'Bearer' . $this->token);
        app()->handle($req);
    }
}
