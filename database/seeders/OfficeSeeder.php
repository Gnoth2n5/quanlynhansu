<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class OfficeSeeder
{
    public function run()
    {
        // Thêm logic fake data vào đây
        Capsule::table('offices')->insert([
            ['name' => 'P101', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P102', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P103', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P104', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P105', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P106', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P107', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P108', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P109', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P110', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'P201', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P202', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P203', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P204', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P205', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P206', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P207', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P208', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P209', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P210', 'location' => 'Tầng 2 toà Alpha'],
            ['name' => 'P301', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P302', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P303', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P304', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P305', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P306', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P307', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P308', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P309', 'location' => 'Tầng 3 toà Alpha'],
            ['name' => 'P310', 'location' => 'Tầng 3 toà Alpha'],
        ]);
    }
}
        