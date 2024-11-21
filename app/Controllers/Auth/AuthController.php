<?php

namespace App\Controllers;
use App\Models\User;

class AuthController extends Controller
{
    public function loginView()
    {
        return $this->render('authentication.signin');
    }

    public function registerView()
    {
        return $this->render('authentication.signup');
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
}