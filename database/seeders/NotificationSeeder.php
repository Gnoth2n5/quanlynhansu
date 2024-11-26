<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class NotificationSeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();
        $officeIds = Capsule::table('offices')->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            Capsule::table('notifications')->insert([
                'user_id'    => $userId,
                'title'      => 'Thông báo mới',
                'message'    => 'Đây là nội dung thông báo.',
                'office_id'  => $officeIds[array_rand($officeIds)],
            ]);
        }
    }
}
        