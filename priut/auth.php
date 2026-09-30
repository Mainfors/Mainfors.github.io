<?php
session_start();
require_once 'config.php';

$error = '';

if (isset($_SESSION['user_id'])) {
    header('Location: UserPage.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Заполните все поля';
    } else {
        $conn = $pdo->prepare('SELECT id, username, password FROM users WHERE email = ?');
        $conn->execute([$email]);
        $user = $conn->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: UserPage.php');
            exit;
        } else {
            $error = 'Неверный email или пароль';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
    <div class="container headerinner">
        <a href="index.php" class="logo">Приют имени Свиридова</a>
        <nav class="nav">
            <a href="index.php" class="navlink">Главная</a>
            <a href="auth.php" class="navlink">Вход</a>
            <a href="reg.php" class="navlink">Регистрация</a>
        </nav>
    </div>
</header>

<main class="main">
    <div class="container">
        <h1 class="title">Вход</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post" class="form">
            <label class="label">Email</label>
            <input type="email" name="email" class="input" required>

            <label class="label">Пароль</label>
            <input type="password" name="password" class="input" required>

            <button type="submit" class="button">Войти</button>
        </form>

        <p class="text">Нет аккаунта? <a href="reg.php" class="link">Зарегистрироваться</a></p>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p class="text">Приют для животных</p>
    </div>
</footer>
</body>
