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
                'end_time'    => '12:00:00',
                'is_overtime' => 0,
            ],
            [
                'shift_name'  => 'Chiều',
                'start_time'  => '14:00:00',
                'end_time'    => '18:00:00',
                'is_overtime' => 0,
            ],
            [
                'shift_name'  => 'Tối',
                'start_time'  => '20:00:00',
                'end_time'    => '24:00:00',
                'is_overtime' => 0,
            ],
        ]);
    }
}
        