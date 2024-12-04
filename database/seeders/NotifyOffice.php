<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class NotifyOffice
{
    public function run()
    {

        $notifyIds = Capsule::table('notifications')->pluck('id')->toArray();
        $officIds = Capsule::table('offices')->pluck('id')->toArray();

        // Thêm logic fake data vào đây
        foreach ($notifyIds as $notifyId) {
            Capsule::table('notify_office')->insert([
                'notify_id' => $notifyId,
                'office_id' => $officIds[array_rand($officIds)],
            ]);
        }
    }
}
