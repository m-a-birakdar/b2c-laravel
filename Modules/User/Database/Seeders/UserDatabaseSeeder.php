<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Modules\Address\Repositories\CuApi\V1\AddressRepository;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Manager
        $user = User::create([
            'name' => 'Manager', 'email' => '1@manager.com', 'phone' => '00905352646729', 'password' => Hash::make('123')
        ]);
        $user->syncRoles('manager');

        // Admin
        $user = User::create([
            'name' => 'Admin', 'email' => '1@admin.com', 'phone' => '00901010101010', 'password' => Hash::make('123')
        ]);
        $user->syncRoles('admin');
        $token = 'Admin ' . $user->createToken('00901010101010')->plainTextToken . PHP_EOL;

        // Courier
        $user = User::create([
            'name' => 'Courier', 'email' => '1@courier.com', 'phone' => '00902020202020', 'password' => Hash::make('123')
        ]);
        $user->syncRoles('courier');
        $token .= 'Courier ' . $user->createToken('00902020202020')->plainTextToken . PHP_EOL;

        // Customer
        $user = User::create([
            'name' => 'Customer', 'email' => '1@customer.com', 'phone' => '00903030303030', 'password' => Hash::make('123')
        ]);
        $user->syncRoles('customer');
        $thisToken = $user->createToken('00903030303030')->plainTextToken;
        $token .= 'Customer ' . $thisToken . PHP_EOL;
        Sanctum::actingAs($user);
        ( new AddressRepository )->store([
            'city_id' => 1,
            'address' => Str::random(100)
        ]);
        Storage::put('token.txt', $token);
    }
}
