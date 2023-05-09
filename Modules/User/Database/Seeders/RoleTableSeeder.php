<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Role::query()->insert([
            ['name' => 'manager'],
            ['name' => 'admin'],
            ['name' => 'courier'],
            ['name' => 'customer'],
        ]);
    }
}
