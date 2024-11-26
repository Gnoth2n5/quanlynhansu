<?php

namespace Database\Seeders;

use Illuminate\Database\Capsule\Manager as Capsule;

class UserSeeder
{
    public function run()
    {
        // Thêm logic fake data vào đây
        Capsule::table('users')->insert([
            [
                'username'   => 'user1',
                'password'   => password_hash('password', PASSWORD_ARGON2ID),
                'full_name'  => 'John Doe',
                'address'    => '123 Main St',
                'birthday'   => '1990-01-01',
                'avatar'     => null,
                'email'      => 'user1@example.com',
                'phone'      => '123456789',
                'role_id'    => 1, // User
                'status'     => 'active',
                'UID'        => uniqid()
            ],
            [
                'username'   => 'admin',
                'password'   => password_hash('adminpassword', PASSWORD_ARGON2ID),
                'full_name'  => 'Admin User',
                'address'    => '456 Admin Ave',
                'birthday'   => '1985-05-15',
                'avatar'     => null,
                'email'      => 'admin@example.com',
                'phone'      => '987654321',
                'role_id'    => 3, // Admin
                'status'     => 'active',
                'UID'        => uniqid()
            ],
            [
                'username'   => 'manager',
                'password'   => password_hash('managerpassword', PASSWORD_ARGON2ID),
                'full_name'  => 'Manager User',
                'address'    => '789 Manager Blvd',
                'birthday'   => '1988-10-20',
                'avatar'     => null,
                'email'      => 'manager@example.com',
                'phone'      => '456789123',
                'role_id'    => 2, // Manager
                'status'     => 'active',
                'UID'        => uniqid()
            ],
        ]);
    }
}
        