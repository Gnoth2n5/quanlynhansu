<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class OfficeUserSeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();
        $officeIds = Capsule::table('offices')->pluck('id')->toArray();

        // Mỗi user được phân công vào một văn phòng ngẫu nhiên
        foreach ($userIds as $userId) {
            Capsule::table('office_users')->insert([
                'user_id' => $userId,
                'office_id' => $officeIds[array_rand($officeIds)],
            ]);
        }
    }
}
        