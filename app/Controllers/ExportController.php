<?php

namespace App\Controllers;

use App\Models\Salaries;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function export()
    {
        $data = Salaries::all();

        foreach ($data as $item) {
            $item->base_salary = number_format($item->base_salary, 0, ',', '.');
            $item->total_deductions = number_format($item->total_deductions, 0, ',', '.');
            $item->total_bonus = number_format($item->total_bonus, 0, ',', '.');
            $item->net_salary = number_format($item->net_salary, 0, ',', '.');
        }

        // tạo file excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // set tiêu đề cột
        $sheet->setCellValue('A1', 'STT');
        $sheet->setCellValue('B1', 'Tên nhân viên');
        $sheet->setCellValue('C1', 'Lương cơ bản');
        $sheet->setCellValue('D1', 'Tổng trừ');
        $sheet->setCellValue('E1', 'Tổng thưởng');
        $sheet->setCellValue('F1', 'Lương thực lĩnh');

        // set dữ liệu
        $row = 2;
        $stt = 1;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $stt);
            $sheet->setCellValue('B' . $row, $item->users->full_name);
            $sheet->setCellValue('C' . $row, $item->base_salary);
            $sheet->setCellValue('D' . $row, $item->total_deductions);
            $sheet->setCellValue('E' . $row, $item->total_bonus);
            $sheet->setCellValue('F' . $row, $item->net_salary);

            $row++;
            $stt++;
        }

        // Đường dẫn đến thư mục cần lưu file
        $directory = 'export/';

        // Kiểm tra xem thư mục đã tồn tại chưa
        if (!is_dir($directory)) {
            // Nếu không tồn tại, tạo thư mục
            mkdir($directory, 0775, true); // 0775 là quyền truy cập, true cho phép tạo thư mục con
        }

        // Tiến hành tạo và lưu file Excel
        $writer = new Xlsx($spreadsheet);
        $filePath = $directory . 'salaries.xlsx'; // Đặt đường dẫn lưu file
        $writer->save($filePath);

        // Sau khi lưu, gửi file cho người dùng tải về
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="salaries.xlsx"');
        header('Cache-Control: max-age=0');

        // Gửi nội dung file cho người dùng
        readfile($filePath);
        exit;
    }
}
