<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => $_ENV['DB_CONNECTION'],
    'host'      => $_ENV['DB_HOST'],
    'port'      => $_ENV['DB_PORT'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
    'options'   => [
        PDO::ATTR_TIMEOUT => 5, // Thời gian timeout
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4', // Khởi động bộ mã
    ],
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// try {
//     Capsule::connection()->getPdo();
//     echo "Database connection successful!";
// } catch (\Exception $e) {
//     echo "Could not connect to the database. Error: " . $e->getMessage();
// }


return $capsule;
