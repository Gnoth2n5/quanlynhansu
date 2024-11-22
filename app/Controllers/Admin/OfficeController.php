<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;

class OfficeController extends Controller
{
    public function index()
    {
        $this->render('pages.admin.office.office');
    }
}