<?php require_once 'config.php'; if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; } ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Вход | ArtSpace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-container">
    <div class="container">
        <h1>ArtSpace</h1>
        <h2>Вход</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error">Неверный логин или пароль</p>
        <?php endif; ?>
        <form method="POST" action="login_handler.php">
            <input type="text" name="login" placeholder="Логин" class="input-dark" required>
            <input type="password" name="password" placeholder="Пароль" class="input-dark" required>
            <button type="submit" class="btn-primary">Войти</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            Ещё не зарегистрированы? <a href="register.php" style="color:white;">Регистрация</a>
        </p>
    </div>
</div>
</body>
</html>