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

$url = $_GET['url'] ?? '/';

try {
    $router = new RouteCollector();

    $router->get('/', [AuthController::class, 'loginView']);
    $router->get('/signup', [AuthController::class, 'registerView']);

    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->get('/logout', [AuthController::class, 'logout']);

    $router->get('/admin/dashboard', [DashboardController::class, 'dashboardAdmin']);

    // Office Management
    $router->get('/admin/office-management', [OfficeController::class, 'index']);
    $router->get('/admin/delete-office/{id}', [OfficeController::class, 'delete']);
    $router->get('/admin/delete-office/{id}', [OfficeController::class, 'delete']);
    // 3 thành phần url controller function 
    $router->get('/admin/create-office', [OfficeController::class, 'create']);
    $router->get('/admin/edit-office/{id}', [OfficeController::class, 'edit']);
<<<<<<< Updated upstream
=======
    $router->post('/admin/store-office', [OfficeController::class, 'store']);
    $router->post('/admin/update-office', [OfficeController::class, 'update']);
    
   
    $router->get('/admin/create-shift', [ShiftController::class, 'create']);
    $router->post('/admin/store-shift', [ShiftController::class, 'store']);
    $router->get('/admin/edit-shift/{id}', [ShiftController::class, 'edit']);
    $router->post('/admin/update-shift', [ShiftController::class, 'update']);
    $router->get('/admin/delete-shift/{id}', [ShiftController::class, 'delete']);
>>>>>>> Stashed changes

    
    // User Management
    $router->get('/admin/user-management', [UserController::class, 'index']);



    // Leave Management
    $router->get('/admin/leave-management', [LeaveController::class, 'index']);


    // Salary Management
    $router->get('/admin/salary-management', [SalaryController::class, 'index']);

    

    
    $router->get('/user/dashboard', [DashboardController::class, 'dashboardUser']);
    $router->get('/user/check-in', [AttendanceController::class, 'checkIn']);
    // $router->get('/user/check-out', [AttendanceController::class, 'checkOut']);
    $router->get('/user/profile', [ProfileController::class, 'profile']);
    $router->get('/user/update-profile', [ProfileController::class, 'updateProfile']);
    
















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