<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use App\Models\Users;
use App\Helpers\Redirect;


class AuthController extends Controller
{
    public function loginView()
    {
        return $this->render('pages.authentication.signin');
    }

    public function registerView()
    {
        return $this->render('pages.authentication.signup');
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $user = Users::where('email', $email)->first();

        \start_session();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user->role->name;
            
            if($user->role->name == 'admin') {
                Redirect::to('/admin/dashboard')
                    ->message('Đăng nhập thành công!', 'success')
                    ->send();
            }
            if($user->role->name == 'user' || $user->role->name == 'manager') {
                Redirect::to('/user/dashboard')
                    ->message('Đăng nhập thành công!', 'success')
                    ->send();
            }
            
        }

        Redirect::to('/')
            ->message('Tài khoản hoặc mật khẩu không chính xác!', 'danger')
            ->send();
    }

    public function register()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!$username || !$email || !$password) {
            echo 'All fields are required';
        }

        $user = new Users();

        $user->username = $username;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_ARGON2ID);
        $user->role_id = 3;
        $user->save();

        Redirect::to('/')
            ->message('Đăng kí thành công', 'success')
            ->send();
    }

    public function logout()
    {
        session_destroy();
        Redirect::to('/')
            ->message('Đăng xuất thành công!', 'success')
            ->send();
    }
}