<?php

namespace App\Controllers\Admin;

use App\Models\Shifts;
use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Services\PaginationService;
use App\Models\Users;
use App\Models\UserShift;

class ShiftController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate(Shifts::query()->orderBy('updated_at', 'desc'), $perPage, $page);

        $this->render('pages.admin.shift.shift', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function show($id)
    {
        $user = Users::with('shift')->find($id);
        $shifts = Shifts::all();

        

        if (!$user) {
            Redirect::to('/admin/shift-management')
                ->message('Người dùng không tồn tại', 'error')
                ->send();
        }
        

        $this->render('pages.admin.shift.shift_assign', [
            'user' => $user,
            'shifts' => $shifts,
        ]);
    }

    public function assign()
    {
        $userId = $_POST['id'];
        $shiftId = $_POST['shift'];

        $user = UserShift::where('user_id', $userId)->first();
        $shift = Shifts::find($shiftId);

        if (!$user || !$shift) {
            Redirect::to('/admin/user-shift')
                ->message('Người dùng hoặc ca làm việc không tồn tại', 'error')
                ->send();
        }

        $user->update([
            'shift_id' => $shiftId,
        ]);

        Redirect::to('/admin/user-shift')
            ->message('Phân công ca làm việc thành công', 'success')
            ->send();
    }

    public function userShift()
    {
        $userShift = Users::with('shift');

        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate($userShift, $perPage, $page);


        $this->render('pages.admin.shift.user_shift', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
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
        $isOvertime = $_POST['isOvertime'] ?? 0;

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
        $isOvertime = $_POST['isOvertime'] ?? 0;

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
