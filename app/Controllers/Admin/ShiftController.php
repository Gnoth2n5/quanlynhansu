<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Models\Shifts;

class ShiftController extends Controller
{
    public function index()
    {
        //lấy oàn bộ dữ liệu
        $shifts = Shifts::all();

        $data = $shifts->map(function($shifts) {
            return [
                'id' => $shifts->id,
                'shift_name' => $shifts->shift_name,
                'start_time' => $shifts->start_time,
                'end_time' => $shifts->end_time,
                'is_overtime' => $shifts->is_overtime,
                
            ];
        });
        $this->render('pages.admin.shift.shift', compact('data'));
        
    }
        
  
    
    
}