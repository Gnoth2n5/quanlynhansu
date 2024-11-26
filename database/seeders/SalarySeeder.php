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
                'base_salary'      => 5000.00,
                'total_salary'     => 6000.00,
                'total_deductions' => 1000.00,
                'net_salary'       => 5000.00,
                'pay_date'         => Carbon::now()->format('Y-m-d'),
            ]);
        }
    }
}
        