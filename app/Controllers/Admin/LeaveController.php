<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;

class LeaveController extends Controller
{
    public function index()
    {
        $this->render('pages.admin.leave.leave');
    }
}