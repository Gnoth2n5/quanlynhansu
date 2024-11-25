<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Services\AttendanceService;

class DashboardController extends Controller
{
    protected $attenSv;
    public function __construct()
    {
        $this->attenSv = new AttendanceService();
    }
    
    public function dashboardAdmin()
    {
        $this->render('pages.admin.dashboard');
    }

    public function dashboardUser()
    {
        \start_session();
        
        $isAttended = $this->attenSv->hasCheckIn($_SESSION['user']->id);

        // \dd($isAttended);

        $this->render('pages.client.dashboard', ['isAttended' => !$isAttended]);
    }
}