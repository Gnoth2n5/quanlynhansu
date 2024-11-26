<?php

namespace App\Controllers\Admin;

use App\Models\Shifts;
<<<<<<< Updated upstream
=======
use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Services\PaginationService;
>>>>>>> Stashed changes

class ShiftController extends Controller
{
    public function index()
    {
<<<<<<< Updated upstream
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
        
=======
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate(Shifts::query()->orderBy('updated_at', 'desc'), $perPage, $page);

        return $this->render('pages.admin.shift.shift', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
>>>>>>> Stashed changes
    }

    public function delete($id)
    {
        $shift = Shifts::find($id);

        if (!$shift) {
            Redirect::to('/admin/shift-management')
                ->message('Ca làm việc không tồn tại', 'error')
                ->send();
        }

        $shift->delete();

        Redirect::to('/admin/shift-management')
            ->message('Xóa ca làm việc thành công', 'success')
            ->send();
    }

    public function create()
    {
        $this->render('pages.admin.shift.create_shift');
    }

    public function edit($id)
    {
        $shift = Shifts::find($id);

        if (!$shift) {
            Redirect::to('/admin/shift-management')
                ->message('Lỗi không tìm thấy ca làm việc', 'error')
                ->send();
        }

        $this->render('pages.admin.shift.edit_shift', ['shift' => $shift]);
    }

    public function store()
    {
        $shiftName = $_POST['shiftName'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $isOvertime = isset($_POST['isOvertime']) ? 1 : 0;

        if (empty($shiftName) || empty($startTime) || empty($endTime)) {
            Redirect::to('/admin/create-shift')
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        $shift = Shifts::where('shift_name', $shiftName)->first();

        if ($shift) {
            Redirect::to('/admin/create-shift')
                ->message('Ca làm việc đã tồn tại', 'error')
                ->send();
        }

        $result = Shifts::create([
            'shift_name' => $shiftName,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_overtime' => $isOvertime,
        ]);

        if (!$result) {
            Redirect::to('/admin/create-shift')
                ->message('Lỗi khi thêm ca làm việc', 'error')
                ->send();
        }

        Redirect::to('/admin/shift-management')
            ->message('Thêm ca làm việc thành công', 'success')
            ->send();
    }

    public function update()
    {
        $id = $_POST['id'];
        $shiftName = $_POST['shiftName'];
        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $isOvertime = isset($_POST['isOvertime']) ? 1 : 0;

        if (empty($shiftName) || empty($startTime) || empty($endTime)) {
            Redirect::to('/admin/edit-shift/' . $id)
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        $shift = Shifts::find($id);

        if (!$shift) {
            Redirect::to('/admin/shift-management')
                ->message('Lỗi không tìm thấy ca làm việc', 'error')
                ->send();
        }

        $shift->shift_name = $shiftName;
        $shift->start_time = $startTime;
        $shift->end_time = $endTime;
        $shift->is_overtime = $isOvertime;
        $shift->save();

        Redirect::to('/admin/shift-management')
            ->message('Cập nhật ca làm việc thành công', 'success')
            ->send();
    }
}
