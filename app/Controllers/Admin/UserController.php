<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $this->render('pages.admin.user.user');
    }
}