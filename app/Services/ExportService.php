<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportService extends Service
{
    protected $columns;
    protected $data;

    public function __construct()
    {
        $this->columns = [];
        $this->data = [];
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function export($filename = 'export.xlsx')
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Đặt tiêu đề cột
        $colIndex = 1;
        $sheet->setCellValue([1, 1], 'STT'); // Add STT column
        $colIndex++;
        foreach ($this->columns as $column) {
            $sheet->setCellValue([$colIndex, 1], $column);
            $colIndex++;
        }

        // Điền dữ liệu vào sheet
        $row = 2;
        foreach ($this->data as $index => $dataRow) {
            $colIndex = 1;
            $sheet->setCellValue([$colIndex, $row], $index + 1); // STT column
            $colIndex++;
            foreach ($this->columns as $key => $column) {
                $sheet->setCellValue([$colIndex, $row], $dataRow[$key]);
                $colIndex++;
            }
            $row++;
        }

        // Đường dẫn đến thư mục cần lưu file
        $directory = 'export/';

        // Kiểm tra xem thư mục đã tồn tại chưa
        if (!is_dir($directory)) {
            // Nếu không tồn tại, tạo thư mục
            mkdir($directory, 0775, true); // 0775 là quyền truy cập, true cho phép tạo thư mục con
        }

        $file_path = $directory . $filename;

        $writer = new Xlsx($spreadsheet);
        $writer->save($file_path);

        return $file_path;
    }

    public function download($filename = 'export.xlsx')
    {
        $file_path = $this->export($filename);

        if (file_exists($file_path)) {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Cache-Control: max-age=0');

            readfile($file_path);
            unlink($file_path); // Xóa file sau khi tải
            exit;
        } else {
            throw new \Exception('File không tồn tại hoặc không thể tạo file.');
        }
    }
}
