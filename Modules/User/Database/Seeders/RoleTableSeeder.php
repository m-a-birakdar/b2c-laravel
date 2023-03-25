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

        $roles = [
            ['ar_name' => 'المدير', 'name' => 'manager'],
            ['ar_name' => 'الزبون', 'name' => 'customer'],
        ];
        Role::query()->insert($roles);
    }
}
