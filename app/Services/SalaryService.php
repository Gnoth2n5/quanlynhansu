<?php

namespace App\Services;

use App\Models\Salaryadjustments;
use App\Models\Salaries;

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
        $this->userId = (int) $userId;
        $this->baseSalary = (int) $baseSalary;
    }

    public function addBonus($money, $description)
    {
        $this->bonusSalary += (int) $money; // Đảm bảo kiểu int
        Salaryadjustments::create([
            'user_id' => $this->userId,
            'salary_id' => null,
            'amount' => $money,
            'description' => $description,
            'type' => 'bonus',
        ]);
        return $this; // Trả về chính đối tượng để chain call
    }

    public function addDeductions($money, $description)
    {
        $this->deductionsSalary += (int) $money; // Đảm bảo kiểu float
        Salaryadjustments::create([
            'user_id' => $this->userId,
            'salary_id' => null,
            'amount' => $money,
            'description' => $description,
            'type' => 'deduction',
        ]);
        return $this;
    }


    public function caculateOT($hours, $rate, $description)
    {
        $amount = $hours * $rate;

        // Kiểm tra nếu đã có OT thì cập nhật thay vì tạo mới
        $existingAdjustment = Salaryadjustments::where('user_id', $this->userId)
            ->where('type', 'ot')
            ->first();

        if ($existingAdjustment) {
            // Nếu đã tồn tại, cập nhật
            $existingAdjustment->update([
                'amount' => $amount,
                'description' => $description,
            ]);
        } else {
            // Nếu chưa tồn tại, thêm mới
            Salaryadjustments::create([
                'user_id' => $this->userId,
                'type' => 'ot',
                'amount' => $amount,
                'description' => $description,
            ]);
        }

        // Cập nhật lương OT
        $this->otSalary = $amount;
    }


    public function caculateNetSalary()
    {
        (int) $this->netSalary = $this->baseSalary + $this->bonusSalary - $this->deductionsSalary + $this->otSalary;

        return $this;
    }

    public function save($salaryId = null)
    {
        $this->validateSalaries();

        // Kiểm tra xem đã tồn tại bản ghi lương của user này hay chưa
        $existingSalary = Salaries::where('user_id', $this->userId)
            ->where('id', $salaryId)
            ->first();

        if ($existingSalary) {
            if ($existingSalary->base_salary != $this->baseSalary || $existingSalary->net_salary != $this->netSalary) {
                $existingSalary->update([
                    'base_salary' => $this->baseSalary,
                    'net_salary' => $this->netSalary,
                ]);
            }

            // lấy salary_id từ bảng salary
            $salaryId = $existingSalary->id;
        } else {
            // Nếu chưa tồn tại, tạo mới
            $salary = Salaries::create([
                'user_id' => $this->userId,
                'base_salary' => $this->baseSalary,
                'net_salary' => $this->netSalary,
            ]);

            // Lấy salary_id từ bản ghi vừa tạo
            $salaryId = $salary->id;
        }
        // Cập nhật salary_id trong bảng salary_adjustments
        Salaryadjustments::where('user_id', $this->userId)
            ->where('salary_id', null)
            ->update(['salary_id' => $salaryId]);
        // echo $this->bonusSalary.'<br>';
        // echo $this->deductionsSalary.'<br>';
        // echo $this->otSalary.'<br>';
        // echo $this->baseSalary.'<br>';
        // echo $this->netSalary.'<br>';
        // die;
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
            throw new \Exception('Khoản điều chỉnh không tồn tại nên không thể cập nhật');
        }

        // Nạp lại dữ liệu cũ vào class
        $this->loadAdjustments();

        $oldAmount = (int) $adjustment->amount;
        $newAmount = (int) $newAmount;

        if ($oldAmount == $newAmount && $adjustment->description == $newDescription) {
            return $this;
        }

        // Cập nhật logic tính toán lương
        if ($adjustment->type == 'bonus') {
            $this->bonusSalary += $newAmount - $oldAmount;
        } elseif ($adjustment->type == 'deduction') {
            $this->deductionsSalary += $newAmount - $oldAmount;
        } elseif ($adjustment->type == 'ot') {
            $this->otSalary += $newAmount - $oldAmount;
        }

        // Cập nhật bản ghi trong cơ sở dữ liệu
        $adjustment->update([
            'amount' => $newAmount,
            'description' => $newDescription,
        ]);

        return $this;
        // echo 'old ' . $oldAmount . '<br>';
        // echo 'new ' . $newAmount . '<br>';
        // echo 'base ' . $this->baseSalary . '<br>';
        // echo $this->bonusSalary . '<br>';
        // echo $this->deductionsSalary . '<br>';
        // echo $this->otSalary . '<br>';

        // echo $this->baseSalary + $this->bonusSalary - $this->deductionsSalary + $this->otSalary . '<br>';

        // die;


        // \dd([
        //     'oldAmount' => $oldAmount,
        //     'newAmount' => $newAmount,
        //     'bonusSalary' => $this->bonusSalary,
        //     'deductionsSalary' => $this->deductionsSalary,
        //     'otSalary' => $this->otSalary,
        // ]);
    }



    public function deleteAdjusment($id)
    {
        $adjustment = Salaryadjustments::find($id);

        if (!$adjustment) {
            throw new \Exception('Khoản điều chỉnh không tồn tại nên không thể xóa');
        }

        // Nạp lại dữ liệu cũ vào class
        $this->loadAdjustments();

        // Cập nhật lương trong class
        if ($adjustment->type == 'bonus') {
            $this->bonusSalary -= $adjustment->amount;
        } elseif ($adjustment->type == 'deduction') {
            $this->deductionsSalary -= $adjustment->amount;
        } elseif ($adjustment->type == 'ot') {
            $this->otSalary -= $adjustment->amount;
        }

        $adjustment->delete();

        return $this;
    }


    private function validateSalaries()
    {
        $calculatedNetSalary = $this->baseSalary + $this->bonusSalary - $this->deductionsSalary + $this->otSalary;

        if ($this->netSalary != $calculatedNetSalary) {
            throw new \Exception('Dữ liệu không đồng bộ giữa class và cơ sở dữ liệu');
        }
    }

    private function loadAdjustments()
    {
        $adjustments = Salaryadjustments::where('user_id', $this->userId)->get();

        $this->bonusSalary = $adjustments->where('type', 'bonus')->sum('amount');
        $this->deductionsSalary = $adjustments->where('type', 'deduction')->sum('amount');
        $this->otSalary = $adjustments->where('type', 'ot')->sum('amount');
    }
}
