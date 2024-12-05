<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class SalarySeeder
{
    public function run()
    {
        $userIds = Capsule::table('users')->pluck('id')->toArray();

        foreach ($userIds as $userId) {
            Capsule::table('salaries')->insert([
                'user_id'          => $userId,
                'base_salary'      => 10000000.00,
                'total_bonus'     => 3000000.00,
                'total_deductions' => 1000000.00,
                'total_allowances' => 100000.00,
                'net_salary'       => 12000000.00,
            ]);
        }
    }
}
        