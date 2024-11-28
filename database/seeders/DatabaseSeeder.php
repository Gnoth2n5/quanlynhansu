<?php

namespace Database\Seeders;

class DatabaseSeeder
{
    public function run()
    {
        // Gọi các Seeder
        $this->call([
            // Thêm các Seeder vào đây
            RoleSeeder::class,
            UserSeeder::class,
            OfficeSeeder::class,
            ShiftSeeder::class,
            NotificationSeeder::class,
            SalarySeeder::class,
            LeaveSeeder::class,
            AttendanceSeeder::class,
            UserShiftSeeder::class,
            OfficeUserSeeder::class,
            SalaryAdjustmentSeeder::class,
            NotifyUser::class,
            NotifyOffice::class,
        ]);
    }

    protected function call(array $seeders)
    {
        foreach ($seeders as $seeder) {
            if (class_exists($seeder)) {
                $instance = new $seeder();
                if (method_exists($instance, 'run')) {
                    $instance->run();
                    echo "Seeder $seeder chạy thành công!\n";
                } else {
                    echo "Seeder $seeder không có method run!\n";
                }
            } else {
                echo "Seeder $seeder không tồn tại!\n";
            }
        }
    }
}
