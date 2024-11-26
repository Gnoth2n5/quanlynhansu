<?php

namespace App\Controllers;

class ProfileController extends Controller
{
    public function profile()
    {
        return $this->render('pages.client.profile');
    }

    public function updateProfile()
    {
        return $this->render('pages.client.profile');
    }
}