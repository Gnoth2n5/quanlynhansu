<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class RoleSeeder
{
    public function run()
    {
        // Thêm logic fake data vào đây
        Capsule::table('roles')->insert([
            ['name' => 'user'],
            ['name' => 'manager'],
            ['name' => 'admin'],
        ]);
    }
}
        