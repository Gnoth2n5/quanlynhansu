<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Models\Users;

class UserController extends Controller
{
    public function index()
    {

        $users = Users::with('role')->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->full_name,
                'role' => $user->role->name ?? 'Unknown', // Thay role_id bằng tên role
                'email' => $user->email,
                'phone' => $user->phone,
                'status' => $user->status,
            ];
        });

        $this->render('pages.admin.user.user', compact('data'));
    }
}