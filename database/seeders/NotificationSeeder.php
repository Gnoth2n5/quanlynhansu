<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class NotificationSeeder
{
    public function run()
    {
        Capsule::table('notifications')->insert([
            [
                'title'   => 'Thông báo thử nghiệm 1',
                'message'   => 'Đây là nội dung thông báo thử nghiệm 1',
            ],
            [
                'title'   => 'Thông báo thử nghiệm 2',
                'message'   => 'Đây là nội dung thông báo thử nghiệm 2',
            ],
            [
                'title'   => 'Thông báo thử nghiệm 3',
                'message'   => 'Đây là nội dung thông báo thử nghiệm 3',
            ],
            [
                'title'   => 'Thông báo thử nghiệm 4',
                'message'   => 'Đây là nội dung thông báo thử nghiệm 4',
            ],
            [
                'title'   => 'Thông báo thử nghiệm 5',
                'message'   => 'Đây là nội dung thông báo thử nghiệm 5',
            ]
        ]);
    }
}
        