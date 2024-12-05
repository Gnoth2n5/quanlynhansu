<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class UserShiftSeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();
        // Giả sử mỗi user được phân công 1 ca làm việc ngẫu nhiên
        foreach ($userIds as $userId) {
            Capsule::table('user_shift')->insert([
                'user_id' => $userId,
                'shift_id' => 1,
            ]);
        }
    }
}
        