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

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
            Redirect::to('/dashboard')
                ->message('Login successfully', 'success')
                ->send();
        }

        Redirect::to('/')
            ->message('Tài khoản hoặc mật khẩu không chính xác', 'danger')
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
            ->message('Register successfully', 'success')
            ->send();
    }

    public function logout()
    {
        session_destroy();
        Redirect::to('/')
            ->message('Logout successfully', 'success')
            ->send();
    }
}