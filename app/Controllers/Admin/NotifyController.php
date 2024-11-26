<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Models\Notifications;

class NotifyController extends Controller
{
    public function index()
    {
        $this->render('pages.admin.notification.notify');
    }
}