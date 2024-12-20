<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/app.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use App\Controllers\DashboardController;
use App\Controllers\Admin\OfficeController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\LeaveController;
use App\Controllers\Admin\SalaryController;
use App\Controllers\Auth\AuthController;
use App\Controllers\AttendanceController;
use App\Controllers\ProfileController;
use App\Controllers\Admin\ShiftController;
use App\Controllers\Admin\NotifyController;
use App\Controllers\Admin\StatisticController;
use App\Controllers\ChartController;
use App\Controllers\SearchController;
use App\Controllers\RequestController;
use App\Controllers\OTController;
use App\Controllers\Admin\SettingController;
use App\Helpers\Redirect;
use App\Midleware\AuthMiddleware;

$url = $_GET['url'] ?? '/';

try {
    $router = new RouteCollector();

    $router->get('/', [AuthController::class, 'loginView']);
    $router->get('/signup', [AuthController::class, 'registerView']);

    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->get('/logout', [AuthController::class, 'logout']);

    $router->filter('auth', function () {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/')
                ->message('Bạn cần đăng nhập để truy cập trang này', 'warning')
                ->send();
        }
        if ($_SESSION['role'] !== 'admin') {
            Redirect::to('/')
                ->message('Bạn không có quyền truy cập trang này', 'warning')
                ->send();
        }
    });

    $router->filter('auth-user', function () {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/')
                ->message('Bạn cần đăng nhập để truy cập trang này', 'warning')
                ->send();
        }
        if ($_SESSION['role'] !== 'user' && $_SESSION['role'] !== 'manager') {
            Redirect::to('/')
                ->message('Bạn không có quyền truy cập trang này', 'warning')
                ->send();
        }
    });

    $router->group(['before' => 'auth'], function ($router) {
        // Dashboard Admin
        $router->get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin']);
        $router->get('/admin/atten-chart', [ChartController::class, 'attenChart']);

        // Office Management
        $router->get('/admin/office-management', [OfficeController::class, 'index']);
        $router->get('/admin/delete-office/{id}', [OfficeController::class, 'delete']);
        // 3 thành phần url controller function 
        $router->get('/admin/create-office', [OfficeController::class, 'create']);
        $router->get('/admin/edit-office/{id}', [OfficeController::class, 'edit']);
        $router->post('/admin/store-office', [OfficeController::class, 'store']);
        $router->post('/admin/update-office', [OfficeController::class, 'update']);

        // User Management
        $router->get('/admin/user-management', [UserController::class, 'index']);
        $router->get('/admin/user-detail/{uid}-{id}', [UserController::class, 'show']);
        $router->get('/admin/block-user/{uid}-{id}', [UserController::class, 'block']);
        $router->get('/admin/unlock-user/{uid}-{id}', [UserController::class, 'unlock']);
        $router->post('/admin/update-user', [UserController::class, 'update']);



        // Leave Management
        $router->get('/admin/leave-management', [LeaveController::class, 'index']);
        $router->get('/admin/leave-request/{type}/{id}', [LeaveController::class, 'confirm']);
        $router->get('/admin/leave-show/{id}', [LeaveController::class, 'show']);
        // Salary Management
        $router->get('/admin/salary-management', [SalaryController::class, 'index']);
        $router->get('/admin/create-salary', [SalaryController::class, 'create']);
        $router->post('/admin/store-salary', [SalaryController::class, 'store']);
        $router->get('/admin/edit-salary/{id}/{userId}', [SalaryController::class, 'edit']);
        $router->post('/admin/update-salary', [SalaryController::class, 'update']);
        $router->get('/admin/delete-salary/{id}', [SalaryController::class, 'delete']);
        // Shift Management
        $router->get('/admin/shift-management', [ShiftController::class, 'index']);
        $router->get('/admin/create-shift', [ShiftController::class, 'create']);
        $router->post('/admin/store-shift', [ShiftController::class, 'store']);
        $router->get('/admin/edit-shift/{id}', [ShiftController::class, 'edit']);
        $router->post('/admin/update-shift', [ShiftController::class, 'update']);
        $router->get('/admin/delete-shift/{id}', [ShiftController::class, 'delete']);

        $router->get('/admin/user-shift', [ShiftController::class, 'userShift']);
        $router->get('/admin/shift-division/{id}', [ShiftController::class, 'show']);
        $router->post('/admin/assign-shift', [ShiftController::class, 'assign']);


        // Notify Management
        $router->get('/admin/notify-management', [NotifyController::class, 'index']);
        $router->get('/admin/create-notify', [NotifyController::class, 'create']);
        $router->post('/admin/store-notify', [NotifyController::class, 'store']);
        $router->get('/admin/delete-notify/{id}', [NotifyController::class, 'delete']);
        $router->get('/admin/edit-notify/{id}', [NotifyController::class, 'show']);
        $router->post('/admin/update-notify', [NotifyController::class, 'update']);
        // OT Management
        $router->get('/admin/ot-management', [OTController::class, 'index']);
        $router->get('/admin/ot-request/{type}/{id}', [OTController::class, 'confirm']);
        // Statistic
        $router->get('/admin/statistic', [StatisticController::class, 'index']);
        $router->post('/admin/statistic/create', [StatisticController::class, 'create']);

        $router->get('/admin/system-setting', [SettingController::class, 'index']);
        $router->post('/admin/system-setting/update', [SettingController::class, 'update']);
    });




    $router->group(['before' => 'auth-user'], function ($router) {

        $router->get('/user/dashboard', [DashboardController::class, 'dashboardUser']);

        $router->get('/user/profile', [ProfileController::class, 'profile']);
        $router->post('/user/update-profile', [ProfileController::class, 'update']);

        $router->get('/user/leave-request', [RequestController::class, 'index']);
        $router->get('/user/leave-request/create', [RequestController::class, 'create']);
        $router->post('/user/leave-request/store', [RequestController::class, 'store']);
        $router->get('/user/leave-request/show/{id}', [RequestController::class, 'show']);
        $router->get('/user/leave-request/delete/{id}', [RequestController::class, 'delete']);
        $router->post('/user/leave-request/update', [RequestController::class, 'update']);

        $router->get('/user/notification', [NotifyController::class, 'index']);
        $router->get('/user/notification/show/{id}', [NotifyController::class, 'show']);

        $router->get('/user/attendance', [AttendanceController::class, 'index']);
        $router->get('/user/check-in', [AttendanceController::class, 'checkIn']);
        $router->get('/user/check-out', [AttendanceController::class, 'checkOut']);
        $router->get('/user/is-early', [AttendanceController::class, 'isEarly']);
        $router->get('/user/check-out-ot', [AttendanceController::class, 'checkOutOT']);

        $router->get('/user/ot-request', [OTController::class, 'index']);
        $router->get('/user/ot-request/create', [OTController::class, 'create']);
        $router->post('/user/ot-request/store', [OTController::class, 'store']);
        $router->get('/user/ot-request/delete/{id}', [OTController::class, 'delete']);
        $router->post('/user/ot-request/update', [OTController::class, 'update']);
        $router->get('/user/ot-request/show/{id}', [OTController::class, 'show']);
    });




    // $router->get('/manager/')



    // search api
    $router->get('/search-user-manager', [SearchController::class, 'search_user_manager']);
    $router->get('/search-user-salary', [SearchController::class, 'search_user_salary']);
    $router->get('/search-office', [SearchController::class, 'search_office']);
    $router->get('/count-notify', [SearchController::class, 'countUnreadNotify']);




    // Route test data
    // $router->get('/test', [SearchController::class, 'search_user_manager']);


    $dispatcher = new Dispatcher($router->getData());
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $url);
    echo $response;
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    dd($e->getMessage());
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
    dd($e->getMessage());
} catch (Exception $e) {
    dd($e->getMessage());
}
