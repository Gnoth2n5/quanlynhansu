<?php
namespace App\Db;

use PDO;
use PDOException;

class Db {
    protected $pdo;
    /**
    * Khởi tạo kết nối tới cơ sở dữ liệu.
    *
    * @param string $host Tên máy chủ cơ sở dữ liệu.
    * @param string $dbname Tên cơ sở dữ liệu.
    * @param string $username Tên đăng nhập cơ sở dữ liệu.
    * @param string $password Mật khẩu cơ sở dữ liệu.
    */
    public function __construct($host = DB_HOST, $dbname = DB_NAME, $username = DB_USERNAME, $password = DB_PASSWORD)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
}