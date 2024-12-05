<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class LeaveSeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            // Bỏ qua nếu người dùng là quản trị viên
            if ($userId === 1) {
                continue;
            }
            Capsule::table('leave_requests')->insert([
                'user_id'    => $userId,
                'start_date' => Carbon::now(),
                'end_date'   => Carbon::now()->addDays(3),
                'reason'     => 'Cần nghỉ phép vì lý do cá nhân',
                'approved_by' => $userIds[array_rand($userIds)],
                'status'     => 'pending'
            ]);
        }
    }
}
        