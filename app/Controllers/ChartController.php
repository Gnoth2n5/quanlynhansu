<?php

namespace App\Controllers;
use App\Models\Attendance;
use App\Controllers\Controller;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function attenChart()
    {

        // Mock data
        $totalCheckIn = Attendance::whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count();
                                    
        $totalCheckInOnTime = Attendance::where('check_in_status', 'on_time')
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)
                                    ->count();
        
        $totalCheckInLate = Attendance::where('check_in_status', 'late')
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->whereYear('created_at', Carbon::now()->year)                    
                                    ->count();
        
        $response = [
            "labels" => ["Tổng chấm công", "Chấm công đúng giờ", "Chấm công muộn"],
            "datasets" => [
                [
                    "data" => [$totalCheckIn, $totalCheckInOnTime, $totalCheckInLate],
                    "backgroundColor" => ["#4CAF50", "#2196F3", "#FF5722"],
                    "hoverBackgroundColor" => ["#66BB6A", "#42A5F5", "#FF7043"]
                ]
            ]
        ];

        return $this->json($response);
    }
}