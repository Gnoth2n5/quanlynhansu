<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use App\Models\User;

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

        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
            return header('Location: /');
        }

        return header('Location: /login');
    }

    public function register()
    {
        $user = new User();
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->save();

        return header('Location: /login');
    }
}