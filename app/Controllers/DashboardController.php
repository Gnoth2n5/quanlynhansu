<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Services\AttendanceService;
use App\Models\Attendance;

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

        $userId = $_SESSION['user']->id;

        $isAttended = $this->attenSv->hasCheckIn($userId);

        // \dd($isAttended);


        $atteMonth = Attendance::where('user_id', $userId)
            ->whereMonth('created_at', date('m'))
            ->count();

        $atteLate = Attendance::where('user_id', $userId)
            ->where('check_in_status', 'late')
            ->whereMonth('created_at', date('m'))
            ->count();

        $this->render('pages.client.dashboard', ['isAttended' => $isAttended, 'atteMonth' => $atteMonth, 'atteLate' => $atteLate]);
    }
}