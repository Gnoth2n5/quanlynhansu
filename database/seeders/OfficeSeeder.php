<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class OfficeSeeder
{
    public function run()
    {
        // Thêm logic fake data vào đây
        Capsule::table('offices')->insert([
            ['name' => 'Phòng IT', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'Phòng Nhân sự', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'Phòng Marketing', 'location' => 'Tầng 1 toà Alpha'],
            ['name' => 'Phòng tài chính - kế toán', 'location' => 'Tầng 1 toà Alpha'],
        ]);
    }
}
        