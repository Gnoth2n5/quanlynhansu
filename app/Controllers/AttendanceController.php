<?php

namespace App\Controllers;

use App\Helpers\Redirect;
use App\Models\Attendance;
use App\Models\Users;
use App\Models\Shifts;
use App\Services\AttendanceService;
use App\Models\UserShift;
use Carbon\Carbon;
use App\Services\PaginationService;

class AttendanceController extends Controller
{
    protected $atteSv;
    
    public function __construct()
    {
        $this->atteSv = new AttendanceService();
    }

    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate(Attendance::where('user_id', $_SESSION['user']->id)->orderBy('updated_at', 'desc'), $perPage, $page);
      
        $this->render('pages.admin.shift.shift', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function checkIn()
    {
        $atten = new Attendance();    
    
        \start_session();
    
        $userId = $_SESSION['user']->id;
    
        $now = Carbon::now()->format('Y-m-d H:i:s');
        
        // true: muộn, false: đúng giờ
        $isLate = $this->atteSv->isLate($now, $userId);
    
        // Lưu thông tin vào database
        $atten->user_id = $userId;
        $atten->check_in = $now;
        $atten->check_out = null;
        $atten->check_in_status = $isLate ? "late" : "on_time";
        $atten->check_out_status = null;
        $atten->save();
    
       
        if ($isLate) {
            return Redirect::to('/user/dashboard')
                            ->message('Bạn đã check-in nhưng muộn giờ làm việc :((', 'error')
                            ->send();
        } else {
            return Redirect::to('/user/dashboard')
                            ->message('Check-in thành công! Bạn đã đúng giờ.', 'success')
                            ->send();
        }
    }

    
}