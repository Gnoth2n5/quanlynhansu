<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class SalaryAdjustmentSeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();
        $salaryIds = Capsule::table('salaries')->pluck('id')->toArray();
        // Giả sử mỗi user có 1 lần điều chỉnh lương trong năm
        foreach ($userIds as $userId) {
            Capsule::table('salary_adjustments')->insert([
                'user_id' => $userId,
                'salary_id' => $salaryIds[array_rand($salaryIds)],
                'type' => 'bonus',
                'amount' => rand(100, 500),
                'description' => 'Thưởng thành tích tốt',
                'adjustment_date' => Carbon::now()->subDays(rand(1, 365))->format('Y-m-d')
            ]);
        }
    }
}
        