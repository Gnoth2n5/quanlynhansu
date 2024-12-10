<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Salaries;
use App\Models\Salaryadjustments;
use App\Services\ExportService;


class StatisticController extends Controller
{
    protected $exportSv;

    public function __construct()
    {
        $this->exportSv = new ExportService();
    }


    public function index()
    {
        $this->render('pages.admin.statistic.statistic');
    }

    public function create()
    {
        $employee = $_POST['employee'] ?? [];
        $selectAll = $_POST['selectAll'] ?? '';
        $from = $_POST['date_from'] ?? null;
        $to = $_POST['date_to'] ?? null;

        // Kiểm tra tính hợp lệ của các tham số đầu vào
        if (!$from || !$to) {
            Redirect::to('/admin/statistic')
                ->message('Thời gian chưa được chọn!', 'error')
                ->send();
        }

        if($from > $to) {
            Redirect::to('/admin/statistic')
                ->message('Thời gian không hợp lệ! Thời gian từ không được lớn hơn thời gian đến!', 'error')
                ->send();
        }

        if ($from == $to) {
            Redirect::to('/admin/statistic')
                ->message('Thời gian không hợp lệ! Thời gian từ không được bằng thời gian đến!', 'error')
                ->send();
        }

        // check box được chọn
        if ($selectAll === 'all') {
            $employee = Salaries::pluck('user_id')->toArray();
        }

        if (empty($employee)) {
            Redirect::to('/admin/statistic')
                ->message('Vui lòng chọn ít nhất 1 nhân viên hoặc chọn tất cả!', 'error')
                ->send();
        }


        $exportData = [];

        foreach ($employee as $item) {
            // Lấy thông tin lương của nhân viên
            $salary = Salaries::with('users', 'users.offices')->where('user_id', $item)->first();

            if (!$salary) {
                Redirect::to('/admin/statistic')
                    ->message('Không tìm thấy thông tin lương của nhân viên', 'error')
                    ->send();
                continue;
            }

            $salaryId = $salary->id;
            $officeName = $salary->users->offices->first()?->name ?? 'Không có phòng ban';

            // Tính tổng tiền giảm trừ
            $sumDeduction = Salaryadjustments::where('type', 'deduction')
                ->where('salary_id', $salaryId)
                ->where('user_id', $item)
                ->whereBetween('created_at', [$from, $to])
                ->sum('amount');

            // Tính tổng tiền thưởng
            $sumBonus = Salaryadjustments::where('type', 'bonus')
                ->where('salary_id', $salaryId)
                ->where('user_id', $item)
                ->whereBetween('created_at', [$from, $to])
                ->sum('amount');

            // Tính tổng tiền OT
            $sumOT = Salaryadjustments::where('type', 'ot')
                ->where('salary_id', $salaryId)
                ->where('user_id', $item)
                ->whereBetween('created_at', [$from, $to])
                ->sum('amount');

            // Tổng lương nhận được
            $totalSalary = $salary->base_salary + $sumBonus + $sumOT - $sumDeduction;

            // Thêm dữ liệu vào danh sách xuất
            $exportData[] = [
                $salary->users->full_name,
                $officeName,
                $salary->base_salary,
                $sumDeduction,
                $sumBonus,
                $sumOT,
                $totalSalary
            ];
        }

        // \dd($exportData);

        if (empty($exportData)) {
            Redirect::to('/admin/statistic')
                ->message('Không có dữ liệu để xuất!', 'error')
                ->send();
        }

        // Định nghĩa cột cho file Excel
        $excelColumns = ['Họ và tên nhân viên', 'Phòng ban', 'Lương cơ bản', 'Khấu trừ', 'Tiền thưởng', 'OT', 'Lương nhận được'];

        // Sử dụng ExportService để xuất file
        $this->exportSv->setColumns($excelColumns);
        $this->exportSv->setData($exportData);
        $this->exportSv->download('salary.xlsx');

        Redirect::to('/admin/statistic')
            ->message('Xuất báo cáo thành công', 'success')
            ->send();
    }
}
