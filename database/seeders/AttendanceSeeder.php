<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class AttendanceSeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            Capsule::table('attendance')->insert([
                'user_id'         => $userId,
                'check_in'        => Carbon::now()->subHours(2),
                'check_out'       => Carbon::now(),
                'check_in_status' => 'on_time',
                'check_out_status'=> 'on_time',
            ]);
        }
    }
}
        