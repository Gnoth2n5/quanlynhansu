<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class NotifyUser
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();
        $notifyIds = Capsule::table('notifications')->pluck('id')->toArray();
        // Thêm logic fake data vào đây
        foreach ($notifyIds as $notify) {
            Capsule::table('notify_user')->insert([
                'notify_id' => $notify,
                'user_id' => $userIds[array_rand($userIds)],
            ]);
        }
    }
}
