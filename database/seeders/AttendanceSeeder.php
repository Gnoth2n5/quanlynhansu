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
            // Lặp qua 30 ngày
            for ($i = 0; $i < 30; $i++) {
                // Tạo ngày hiện tại, trừ đi số ngày lùi lại
                $date = Carbon::now()->subDays($i);

                // Bỏ qua nếu ngày là Chủ nhật (Sunday = 0)
                if ($date->dayOfWeek === Carbon::SUNDAY) {
                    continue;
                }

                // Tạo bản ghi chấm công
                Capsule::table('attendance')->insert([
                    'user_id'         => $userId,
                    'check_in'        => (clone $date)->setTime(8, 0), // Giờ vào là 8:00 AM
                    'check_out'       => (clone $date)->setTime(17, 0), // Giờ ra là 6:00 PM
                    'check_in_status' => 'on_time',
                    'check_out_status' => 'on_time',
                ]);
            }
        }
    }
}
