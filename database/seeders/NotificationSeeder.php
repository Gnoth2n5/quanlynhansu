<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class NotificationSeeder
{
    public function run()
    {
        Capsule::table('notifications')->insert([
            [
                'title'   => 'Notification 1',
                'message'   => 'This is notification 1',
            ],
            [
                'title'   => 'Notification 2',
                'message'   => 'This is notification 2',
            ],
            [
                'title'   => 'Notification 3',
                'message'   => 'This is notification 3',
            ],
        ]);
    }
}
        