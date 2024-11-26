<?php

namespace App\Controllers;
use App\Controllers\Controller;
use App\Services\AttendanceService;
use App\Models\Attendance;
use App\Models\LeaveRequests;
use App\Models\Notifications;
use App\Models\Users;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $attenSv;
    public function __construct()
    {
        $this->attenSv = new AttendanceService();
    }

    public function dashboardAdmin()
    {
        $totalUser = Users::count();

        $totalCheckInLate = Attendance::where('check_in_status', 'late')
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)                    
                                    ->count();

        $totalNotify = Notifications::whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count();

        $totalLeaveRequest = LeaveRequests::where('status', 'pending')
                                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->count();
        $totalCheckIn = Attendance::whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count();
                                    
        $totalCheckInOnTime = Attendance::where('check_in_status', 'on_time')
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count();
                                    
        
        $this->render('pages.admin.dashboard', [
            'totalUser' => $totalUser,
            'totalCheckIn' => $totalCheckIn,
            'totalCheckInLate' => $totalCheckInLate,
            'totalCheckInOnTime' => $totalCheckInOnTime,
            'totalNotify' => $totalNotify,
            'totalLeaveRequest' => $totalLeaveRequest
        ]);
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