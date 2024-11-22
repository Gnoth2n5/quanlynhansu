<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $this->render('pages.admin.dashboard');
    }
}