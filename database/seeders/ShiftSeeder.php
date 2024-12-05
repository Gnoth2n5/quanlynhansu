<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class ShiftSeeder
{
    public function run()
    {
        // Thêm logic fake data vào đây
        Capsule::table('shifts')->insert([
            [
                'shift_name'  => 'Sáng',
                'start_time'  => '08:00:00',
                'end_time'    => '17:00:00',
                'is_overtime' => 0,
            ],
            [
                'shift_name'  => 'Tối',
                'start_time'  => '18:00:00',
                'end_time'    => '23:00:00',
                'is_overtime' => 0,
            ],
        ]);
    }
}
        