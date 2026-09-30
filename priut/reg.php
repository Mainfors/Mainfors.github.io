<?php
session_start();
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Заполните все поля';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Некорректный email';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен быть не менее 6 символов';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают';
    } else {
        $conn= $pdo->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
        $conn->execute([$email, $username]);
        if ($conn->fetch()) {
            $error = 'Пользователь с таким email или именем уже существует';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
            $conn->execute([$username, $email, $hash]);
            $success = 'Регистрация прошла успешно. Теперь вы можете войти.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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
        <h1 class="title">Регистрация</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="post" class="form">
            <label class="label">Имя пользователя</label>
            <input type="text" name="username" class="input" required>

            <label class="label">Email</label>
            <input type="email" name="email" class="input" required>

            <label class="label">Пароль</label>
            <input type="password" name="password" class="input" required>

            <label class="label">Подтвердите пароль</label>
            <input type="password" name="confirm" class="input" required>

            <button type="submit" class="button">Зарегистрироваться</button>
        </form>

        <p class="text">Уже есть аккаунт? <a href="auth.php" class="link">Войти</a></p>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p class="text">Приют для животных</p>
    </div>
</footer>
</body>
</html>