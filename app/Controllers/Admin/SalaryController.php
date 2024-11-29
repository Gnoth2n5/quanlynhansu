<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Salaries;
use App\Services\PaginationService;

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
        $deductionsSalary = $_POST['deductions'] ?? 0;
        $bonusSalary = $_POST['bonus'] ?? 0;

        if($userId == '' || $baseSalary == '' || $userId == 0) {
            Redirect::to('/admin/create-salary')
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }


        $netSalary = $baseSalary + $bonusSalary - $deductionsSalary;


        $salary = new Salaries();
        $salary->user_id = $userId;
        $salary->base_salary = $baseSalary;
        $salary->total_deductions = $deductionsSalary;
        $salary->total_bonus = $bonusSalary;
        $salary->net_salary = $netSalary;
        $salary->save();

        Redirect::to('/admin/salary-management')
            ->message('Tạo bảng lương thành công', 'success')
            ->send();
    }

    public function edit($id)
    {
        $salary = Salaries::find($id);

        $this->render('pages.admin.salary.edit', [
            'salary' => $salary
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $baseSalary = $_POST['base'];
        $deductionsSalary = $_POST['deductions'] ?? 0;
        $bonusSalary = $_POST['bonus'] ?? 0;

        if($baseSalary == '') {
            Redirect::to('/admin/edit-salary/' . $id)
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        $netSalary = $baseSalary + $bonusSalary - $deductionsSalary;

        $salary = Salaries::find($id);
        $salary->base_salary = $baseSalary;
        $salary->total_deductions = $deductionsSalary;
        $salary->total_bonus = $bonusSalary;
        $salary->net_salary = $netSalary;
        $salary->save();

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