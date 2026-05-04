<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $fio = $_POST['fio'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    
    if (!preg_match('/^[A-Za-z0-9]{6,}$/', $login)) 
        header('Location: register.php?error=Логин должен быть латиница+цифры, ≥6 символов');
    elseif (strlen($password) < 8) 
        header('Location: register.php?error=Пароль не менее 8 символов');
    elseif (!preg_match('/^[А-Яа-яЁё\s]+$/u', $fio)) 
        header('Location: register.php?error=ФИО только кириллица и пробелы');
    elseif (!preg_match('/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $number)) 
        header('Location: register.php?error=Неверный формат телефона (8(ХХХ)ХХХ-ХХ-ХХ)');
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        header('Location: register.php?error=Неверный email');
    else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = ?");
        $stmt->execute([$login]);
        if ($stmt->fetch()) {
            header('Location: register.php?error=Логин уже занят');
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (login, password, fio, number, email, role) VALUES (?, ?, ?, ?, ?, 'user')");
            $stmt->execute([$login, $hashed, $fio, $number, $email]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_login'] = $login;
            $_SESSION['user_fio'] = $fio;
            $_SESSION['user_role'] = 'user';
            header('Location: dashboard.php');
        }
    }
    exit;
} else {
    header('Location: register.php');
}