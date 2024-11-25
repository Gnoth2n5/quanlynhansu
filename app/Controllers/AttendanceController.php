<?php

namespace App\Controllers;

use App\Helpers\Redirect;
use App\Models\Attendance;
use App\Models\Users;
use App\Models\Shifts;
use App\Services\AttendanceService;
use App\Models\UserShift;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $atteSv;
    
    public function __construct()
    {
        $this->atteSv = new AttendanceService();
    }

    public function checkIn(){
        
        \start_session();

        $userId = $_SESSION['user']->id;

        $now = Carbon::now()->format('H:i:s');
        
        if(!$this->atteSv->isLate($now, $userId)){
            Redirect::to('/user/dashboard')
                    ->message('You are late for work', 'error')
                    ->send();
        }
        
        return Redirect::to('/user/dashboard')
                        ->message('Check in successful', 'success')
                        ->send();
    }
}