<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;
use Faker\Factory as Faker;


class UserSeeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {

        $roles = Capsule::table('roles')->pluck('id')->toArray();

        $data = [];

        // 1 admin
        $data[] = [
            'username'   => 'admin',
            'password'   => password_hash('adminpassword', PASSWORD_ARGON2ID),
            'full_name'  => $this->faker->name,
            'address'    => $this->faker->address,
            'birthday'   => $this->faker->date('Y-m-d', '1985-01-01'),
            'avatar'     => null,
            'email'      => 'admin@example.com',
            'phone'      => $this->faker->phoneNumber,
            'gender'     => 'male',
            'role_id'    => 1,
            'status'     => 'active',
            'UID'        => uniqid()
        ];

        // 4 manager
        for ($i = 1; $i <= 4; $i++) {
            $data[] = [
                'username'   => "manager{$i}",
                'password'   => password_hash('managerpassword', PASSWORD_ARGON2ID),
                'full_name'  => $this->faker->name,
                'address'    => $this->faker->address,
                'birthday'   => $this->faker->date('Y-m-d', '1990-01-01'),
                'avatar'     => null,
                'email'      => $this->faker->unique()->email,
                'phone'      => $this->faker->phoneNumber,
                'gender'     => $this->faker->randomElement(['male', 'female']),
                'role_id'    => 2,
                'status'     => 'active',
                'UID'        => uniqid()
            ];
        }

        // Thêm 16 user
        for ($i = 1; $i <= 16; $i++) {
            $data[] = [
                'username'   => "user{$i}",
                'password'   => password_hash('userpassword', PASSWORD_ARGON2ID),
                'full_name'  => $this->faker->name,
                'address'    => $this->faker->address,
                'birthday'   => $this->faker->date('Y-m-d', '2000-01-01'),
                'avatar'     => null,
                'email'      => $this->faker->unique()->email,
                'phone'      => $this->faker->phoneNumber,
                'gender'     => $this->faker->randomElement(['male', 'female']),
                'role_id'    => 3,
                'status'     => 'active',
                'UID'        => uniqid()
            ];
        }

        // Thêm logic fake data vào đây
        Capsule::table('users')->insert($data);
    }
}
