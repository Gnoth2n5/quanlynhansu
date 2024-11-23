<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;

class SalaryController extends Controller
{
    public function index()
    {
        $this->render('pages.admin.salary.salary');
    }
}