<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Attendance;
use App\Models\Salaries;
use App\Services\PaginationService;
use App\Services\SalaryService;
use Carbon\Carbon;
use App\Models\OT;
use App\Models\Salaryadjustments;
use App\Models\Users;

class SalaryController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $salaries = Salaries::with('users')->orderBy('updated_at', 'desc');

        $pagination = PaginationService::paginate($salaries, $perPage, $page);

        $this->render('pages.admin.salary.salary', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function create()
    {
        $this->render('pages.admin.salary.create');
    }

    public function store()
    {
        $userId = $_POST['userId'];
        $baseSalary = $_POST['base'];

        $deductions = isset($_POST['deductions']) ? $_POST['deductions'] : [];
        $bonus = isset($_POST['bonus']) ? $_POST['bonus'] : [];

        if ($userId == '' || $userId == 0 || $baseSalary == '') {
            Redirect::to('/admin/create-salary')
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        $salary = Salaries::where('user_id', $userId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();

        if ($salary) {
            Redirect::to('/admin/salary-management')
                ->message('Bảng lương của nhân viên đã được tạo', 'error')
                ->send();
        }

        $salaryService = new SalaryService($userId, $baseSalary);

        // Xử lý deductions: bỏ qua nếu giá trị rỗng
        if (!empty($deductions) && isset($deductions['amount'])) {
            for ($i = 0; $i < count($deductions['amount']); $i++) {
                if (!empty($deductions['amount'][$i])) {
                    $salaryService->addDeductions($deductions['amount'][$i], $deductions['description'][$i]);
                }
            }
        }

        // Xử lý bonus: bỏ qua nếu giá trị rỗng
        if (!empty($bonus) && isset($bonus['amount'])) {
            for ($i = 0; $i < count($bonus['amount']); $i++) {
                if (!empty($bonus['amount'][$i])) {
                    $salaryService->addBonus($bonus['amount'][$i], $bonus['description'][$i]);
                }
            }
        }

        $work_ot_hour = $this->calculateOTHour($userId);
        if ($work_ot_hour !== null && $work_ot_hour > 0) {
            $otRate = 20000;
            $salaryService->caculateOT($work_ot_hour, $otRate, 'Làm thêm giờ');
        }


        $salaryService->caculateNetSalary();

        $salaryService->save();


        Redirect::to('/admin/salary-management')
            ->message('Tạo bảng lương thành công', 'success')
            ->send();
    }

    public function calculateOTHour($userId)
    {

        $totalOTMinutes = 0;

        // Lấy thông tin các lần check out OT trong tháng hiện tại
        $attendanceOT = Attendance::where('user_id', $userId)
            ->where('check_out_status', 'ot')
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();

        // Lấy thông tin nhân viên và ca làm việc
        $user = Users::with('shift')->find($userId);

        if (!$user || $user->shift->isEmpty()) {
            throw new \Exception('Không tìm thấy thông tin ca làm việc của nhân viên');
        }

        // Lấy thông tin ca làm việc
        $shift = $user->shift->first(); // Lấy ca đầu tiên (nếu chỉ có 1 ca)
        $shiftEndTime = Carbon::parse($shift->end_time)->format('H:i');  // Chỉ giữ giờ và phút

        // Duyệt qua các lần checkout để tính OT
        foreach ($attendanceOT as $attendance) {
            $checkOutTime = Carbon::parse($attendance->check_out)->format('H:i');  // Chỉ giữ giờ và phút

            // Convert lại thành Carbon để tính toán sự chênh lệch
            $checkOutTimeCarbon = Carbon::createFromFormat('H:i', $checkOutTime);
            $shiftEndTimeCarbon = Carbon::createFromFormat('H:i', $shiftEndTime);

            // Chỉ tính OT nếu checkout sau giờ kết thúc ca
            $diffInMinutes = $shiftEndTimeCarbon->diffInMinutes($checkOutTimeCarbon, false);

            if ($diffInMinutes > 0) {
                $totalOTMinutes += $diffInMinutes;
            } else {
                $diffInMinutes = 0;
            }
        }

        $totalOTHours = round($totalOTMinutes / 60, 2);
        return $totalOTHours; // Hoặc trả về giờ
    }



    public function edit($id, $userId)
    {
        $salary = Salaries::with('users')->find($id);

        if (!$salary) {
            Redirect::to('/admin/salary-management')
                ->message('Không tìm thấy bảng lương', 'error')
                ->send();
        }

        $adjusment = (new SalaryService($userId, $salary->base_salary))->getAdjusments(null, $id);

        $this->render('pages.admin.salary.edit', [
            'salary' => $salary,
            'adjusment'  => $adjusment,
        ]);
    }

    public function update()
    {
        $salary_id = $_POST['salary_id'];
        $userId = $_POST['user_id'];
        $baseSalary = $_POST['base'];

        $deductionsSalary = $_POST['deductions'] ?? [];
        $bonusSalary = $_POST['bonus'] ?? [];

        $delete_ids = $_POST['deleted_ids'] ?? null;


        if ($userId == '' || $userId == 0 || $baseSalary == '') {
            Redirect::to('/admin/salary-management')
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        $salary_service = new SalaryService($userId, $baseSalary);

        // xoá các khoản điều chỉnh đã được check
        if (isset($delete_ids) && !empty($delete_ids)) {
            $deletedIds = explode(',', $delete_ids);
            foreach ($deletedIds as $delete_id) {
                $salary_service->deleteAdjusment((int)$delete_id);
            }
        }

        foreach ($deductionsSalary as $deduction) {
            if (!empty($deduction['id'])) {
                // Nếu ID tồn tại, cập nhật bản ghi đã có
                $salary_service->updateAdjusment(
                    $deduction['id'],
                    $deduction['amount'],
                    $deduction['description']
                );
            } elseif (!empty($deduction['amount']) && !empty($deduction['description'])) {
                // Nếu ID không tồn tại và có giá trị, thêm mới
                $salary_service->addDeductions(
                    $deduction['amount'],
                    $deduction['description']
                );
            }
        }

        foreach ($bonusSalary as $bonus) {
            if (!empty($bonus['id'])) {
                // Nếu ID tồn tại, cập nhật bản ghi đã có
                $salary_service->updateAdjusment(
                    $bonus['id'],
                    $bonus['amount'],
                    $bonus['description']
                );
            } elseif (!empty($bonus['amount']) && !empty($bonus['description'])) {
                // Nếu ID không tồn tại và có giá trị, thêm mới
                $salary_service->addBonus(
                    $bonus['amount'],
                    $bonus['description']
                );
            }
        }


        // die;

        $work_ot_hour = $this->calculateOTHour($userId);
        if ($work_ot_hour !== null && $work_ot_hour > 0) {
            $otRate = 20000;
            $salary_service->caculateOT($work_ot_hour, $otRate, 'Làm thêm giờ');
        }

        // Tính toán lương net
        $salary_service->caculateNetSalary();

        $salary_service->save($salary_id);

        Redirect::to('/admin/salary-management')
            ->message('Cập nhật bảng lương thành công', 'success')
            ->send();
    }

    public function delete($id)
    {
        $salary = Salaries::find($id);
        $salary->delete();

        Redirect::to('/admin/salary-management')
            ->message('Xóa bảng lương thành công', 'success')
            ->send();
    }
}
