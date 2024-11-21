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
}