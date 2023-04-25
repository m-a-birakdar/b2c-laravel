<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
//        User::factory()->count(10)->create();
    }
}
