<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class OfficeUserSeeder
{
    public function run()
    {
        $officeIds = Capsule::table('offices')->pluck('id')->toArray();

        // Phân loại user IDs theo vai trò
        $managers = Capsule::table('users')->where('role_id', 2)->pluck('id')->toArray(); // Managers
        $users = Capsule::table('users')->where('role_id', 3)->pluck('id')->toArray(); // Regular Users

        // Kiểm tra số lượng phòng ban và managers
        if (count($officeIds) > count($managers)) {
            die("Không đủ managers để phân phối mỗi phòng ban một người quản lý!");
        }

        // Gán mỗi phòng ban một manager
        foreach ($officeIds as $index => $officeId) {
            Capsule::table('office_users')->insert([
                'user_id' => $managers[$index], // Lấy một manager cho mỗi phòng ban
                'office_id' => $officeId,
            ]);
        }
        // Gán các users còn lại vào phòng ban ngẫu nhiên
        foreach ($users as $userId) {
            Capsule::table('office_users')->insert([
                'user_id' => $userId,
                'office_id' => $officeIds[array_rand($officeIds)], // Phòng ban ngẫu nhiên
            ]);
        }
    }
}
