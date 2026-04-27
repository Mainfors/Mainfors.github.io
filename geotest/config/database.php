<?php
// config/database.php

// Запуск сессии должен быть ПЕРЕД любым выводом
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Database {
    private $host = "localhost";
    private $db_name = "geo_test";
    private $username = "root";  // Измените на свои данные
    private $password = "";      // Измените на свои данные
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $exception) {
            die("Ошибка подключения к базе данных: " . $exception->getMessage());
        }
        return $this->conn;
    }
}
?>