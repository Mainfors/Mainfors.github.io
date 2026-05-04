<?php
session_start();

$host = 'localhost';
$dbname = 'sanekk';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        login VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        fio VARCHAR(255) NOT NULL,
        number VARCHAR(20) NOT NULL,
        email VARCHAR(100) NOT NULL,
        role ENUM('admin','user') NOT NULL DEFAULT 'user'
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS requests (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        date DATETIME NOT NULL,
        payment_type ENUM('cash','transfer') NOT NULL DEFAULT 'cash',
        status ENUM('send','confirm','complete') NOT NULL DEFAULT 'send',
        review TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");
    
    // Создание администратора, если отсутствует
    $stmt = $pdo->prepare("SELECT id FROM users WHERE login = 'ArtAdmin'");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $adminHash = password_hash('Creative', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (login, password, fio, number, email, role) VALUES ('ArtAdmin', ?, 'Администратор', '8(999)123-45-67', 'admin@artspace.ru', 'admin')");
        $stmt->execute([$adminHash]);
    }
} catch (PDOException $e) {
    die("Ошибка БД: " . $e->getMessage());
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>