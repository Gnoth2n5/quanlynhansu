<?php
// BaseController here
namespace App\Controllers;

use eftec\bladeone\BladeOne;

abstract class Controller
{

    protected $url;

    public function __construct()
    {
        $this->url = $_ENV['APP_URL'];
    }
    /**
     * Render một view Blade.
     *
     * @param string $viewFile Tên file view cần render.
     * @param array $data Dữ liệu truyền vào view.
     */
    protected function render($viewFile, $data = [])
    {
        $viewDir = __DIR__ . "/../../src/views";
        $storageDir = __DIR__ . "/../../storage/cache";
        $blade = new BladeOne(null, null, BladeOne::MODE_DEBUG);
        $blade->setPath($viewDir, $storageDir);
        echo $blade->run($viewFile, $data);
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    protected function upload($inputName = 'file', $allowed = ['jpg', 'jpeg', 'png'], $uploadDir = __DIR__ . "/../../public/uploads/avatar/")
    {
        if (!isset($_FILES[$inputName])) {
            return 'Không tìm thấy file upload';
        }

        $file = $_FILES[$inputName];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        // Lấy phần mở rộng file
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        // Kiểm tra loại file
        if (!in_array($fileActualExt, $allowed)) {
            return 'Không thể upload loại file này';
        }

        // Kiểm tra loại MIME
        $mimeType = mime_content_type($fileTmp);
        if (!str_starts_with($mimeType, 'image/')) {
            return 'File không phải là ảnh hợp lệ';
        }

        // Kiểm tra lỗi trong quá trình upload
        if ($fileError !== 0) {
            return 'Có lỗi xảy ra khi upload file';
        }

        // Kiểm tra kích thước file
        if ($fileSize > 3000000) {
            return 'File quá lớn (tối đa 3MB)';
        }

        // Đảm bảo thư mục upload tồn tại
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                return 'Không thể tạo thư mục lưu trữ file';
            }
        }

        // Đổi tên file và lưu
        $fileNameNew = uniqid('image_', true) . "." . $fileActualExt;
        $fileDestination = $uploadDir . $fileNameNew;

        if (move_uploaded_file($fileTmp, $fileDestination)) {
            return $fileNameNew;
        } else {
            return 'Không thể lưu file';
        }
    }
}
