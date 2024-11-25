<?php

namespace App\Services;
use App\Models\UserShift;
use App\Models\Shifts;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceService extends Service
{
    public function isLate($checkIn, $userId, $gracePeriod = 15): bool
    {
        // Lấy giờ bắt đầu ca làm việc
        $shift = UserShift::where('user_id', $userId)
        ->first()
        ->shift
        ->start_time;
            
        // Lấy giờ kết thúc ca làm việc
        $shiftEndTime = UserShift::where('user_id', $userId)
                   ->first()
                   ->shift
                   ->end_time;

        // \dd($checkIn);
        
            
        // Chuyển đổi thời gian check-in và thời gian ca làm việc thành timestamp
        $checkInTime = strtotime($checkIn);
        $shiftTime = strtotime($shift);
        $shiftEndTime = strtotime($shiftEndTime);

        
            
        // Tính toán thời gian ân hạn (thêm vào giờ bắt đầu ca làm việc)
        $gracePeriodEnd = $shiftTime + ($gracePeriod * 60);
            
        // Kiểm tra xem check-in có muộn không
        return $checkInTime <= $gracePeriodEnd && $checkInTime <= $shiftEndTime;
    }

    // public function isEarly($checkOut, $shift, $gracePeriod = 15): bool
    // {
    //     $checkOutTime = strtotime($checkOut);
    //     $shiftTime = strtotime($shift);
    //     return $checkOutTime >= ($shiftTime - $gracePeriod*60);
    // }

    public function hasCheckIn($userId): bool
    {
        return Attendance::where('user_id', $userId)
                        ->whereNotNull('check_in')
                        ->whereDate('check_in', '!=', Carbon::today())
                        ->exists();
    }
}