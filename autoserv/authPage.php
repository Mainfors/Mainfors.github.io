<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Вход</h2>
    
    <?php if(isset($_SESSION['message'])): ?>
        <p>
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </p>
    <?php endif; ?>

    <form action="php/auth.php" method="POST">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    
    <div class="link-group">
        <a href="index.php">Нет аккаунта? Регистрация</a>
    </div>
</div>
</body>
</html>