<?php

namespace App\Midleware;

use App\Helpers\Redirect;

class AuthMiddleware
{
    public function __invoke($request, $next)
    {
        // Kiểm tra session hoặc token xem user đã đăng nhập chưa
        if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
            // Nếu không phải admin, chuyển hướng về trang login
            Redirect::to('/')
                ->message('Bạn không có quyền truy cập trang này')
                ->send();
        }

        // Tiếp tục nếu hợp lệ
        return $next($request);
    }
}
