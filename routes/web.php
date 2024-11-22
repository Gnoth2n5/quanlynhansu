<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/app.php';

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\OfficeController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\LeaveController;
use App\Controllers\Admin\SalaryController;
use App\Controllers\Auth\AuthController;

$url = $_GET['url'] ?? '/';

try {
    $router = new RouteCollector();

    $router->get('/', [AuthController::class, 'loginView']);
    $router->get('/signup', [AuthController::class, 'registerView']);

    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/register', [AuthController::class, 'register']);
    $router->get('/logout', [AuthController::class, 'logout']);

    $router->get('/dashboard', [DashboardController::class, 'dashboard']);

    // Office Management
    $router->get('/office-management', [OfficeController::class, 'index']);


    // User Management
    $router->get('/user-management', [UserController::class, 'index']);



    // Leave Management
    $router->get('/leave-management', [LeaveController::class, 'index']);


    // Salary Management
    $router->get('/salary-management', [SalaryController::class, 'index']);




















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