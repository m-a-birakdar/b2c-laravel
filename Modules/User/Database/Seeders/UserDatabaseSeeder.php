<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Manager',
            'email' => '1@manager.com',
            'phone' => '00905352646729',
            'password' => Hash::make('123')
        ]);
        $user->syncRoles('manager');
        $user = User::create([
            'name' => 'Customer',
            'email' => '1@customer.com',
            'phone' => '00901010101010',
            'password' => Hash::make('123')
        ]);
        $user->syncRoles('customer');
        $token1 = $user->createToken('00901010101010')->plainTextToken;
        Storage::put('token.txt', $token1);
//        User::factory()->count(10)->create();
    }
}
