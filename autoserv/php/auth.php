<?php
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    exit();
}
session_start();

$login = trim($_POST['login']);
$password = $_POST['password'];

if ($login === 'admin' && $password === 'admin123') {
    $_SESSION['user_id'] = 1;
    $_SESSION['role'] = 'admin';
    $_SESSION['fio'] = 'администратор';
    header("Location: ../admin.php");
    exit();
}

// обычный пользователь
require_once '../db/connection.php';
$check = $conn->prepare("SELECT * FROM users WHERE login = :login");
$check->execute([':login' => $login]);
$user = $check->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['fio'] = $user['fio'];
    
    if ($user['role'] === 'admin') {
        header("Location: ../admin.php");
    } else {
        header("Location: ../userPage.php");
    }
    exit();
} else {
    $_SESSION['message'] = "Неверный логин или пароль!";
    header("Location: ../authPage.php?stat=error");
    exit();
}
?>