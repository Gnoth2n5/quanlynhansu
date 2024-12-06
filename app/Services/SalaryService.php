<?php

namespace App\Services;

use App\Models\Salaryadjustments;
use App\Models\Salaries;
use Carbon\Carbon;

class SalaryService extends Service
{
    private $userId;
    private $baseSalary = 0;
    private $deductionsSalary = 0;
    private $bonusSalary = 0;
    private $netSalary = 0;
    private $otSalary = 0;

    public function __construct($userId, $baseSalary)
    {
        $this->userId = $userId;
        $this->baseSalary = $baseSalary;
    }

    public function addBonus($money, $description)
    {
        $this->bonusSalary += $money;
        Salaryadjustments::create([
            'user_id' => $this->userId,
            'salary_id' => null,
            'amount' => $money,
            'description' => $description,
            'type' => 'bonus',
        ]);
        return $this;
    }

    public function addDeductions($money, $description)
    {
        $this->deductionsSalary += $money;
        Salaryadjustments::create([
            'user_id' => $this->userId,
            'salary_id' => null,
            'amount' => $money,
            'description' => $description,
            'type' => 'deduction',
        ]);
        return $this;
    }

    public function caculateOT($hoursWorked, $otRate, $description)
    {
        $otAmount = $hoursWorked * $otRate;
        $this->otSalary += $otAmount;

        Salaryadjustments::create([
            'user_id' => $this->userId,
            'salary_id' => null,
            'amount' => $otAmount,
            'description' => $description,
            'type' => 'ot',
        ]);

        return $this;
    }

    public function caculateNetSalary()
    {
        $this->netSalary = $this->baseSalary + $this->bonusSalary - $this->deductionsSalary + $this->otSalary;
        return $this;
    }

    public function save()
    {
        $salary = Salaries::create([
            'user_id' => $this->userId,
            'base_salary' => $this->baseSalary,
            'net_salary' => $this->netSalary,
        ]);

        // Lấy salary_id từ bảng lương vừa tạo
        $salaryId = $salary->id;

        // Cập nhật salary_id trong bảng salary_adjustments
        Salaryadjustments::where('user_id', $this->userId)
            ->where('salary_id', null)
            ->update(['salary_id' => $salaryId]);
    }


    public function getAdjusments($type = null, $salaryId = null)
    {
        $query =  Salaryadjustments::where('user_id', $this->userId)
            ->where('salary_id', $salaryId);
        if ($type) {
            $query->where('type', $type);
        }

        return $query->get();
    }

    public function updateAdjusment($id, $newAmount, $newDescription)
    {
        $adjustment = Salaryadjustments::find($id);

        if (!$adjustment) {
            throw new \Exception('Khoản điều chỉnh không tồn tại');
        }

        $adjustment->amount = $newAmount;
        $adjustment->description = $newDescription;
        $adjustment->save();

        // cập nhật lại lương trong class
        if ($adjustment->type == 'bonus') {
            $this->bonusSalary = $this->bonusSalary - $adjustment->amount + $newAmount;
        } elseif ($adjustment->type == 'deductions') {
            $this->deductionsSalary = $this->deductionsSalary - $adjustment->amount + $newAmount;
        } elseif ($adjustment->type == 'ot') {
            $this->otSalary = $this->otSalary - $adjustment->amount + $newAmount;
        }

        return $this;
    }
}
