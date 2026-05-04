<?php require_once 'config.php'; if (isset($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; } ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регистрация | ArtSpace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-container">
    <div class="container">
        <h2>Регистрация</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form method="POST" action="register_handler.php">
            <input type="text" name="login" placeholder="Логин (латиница, цифры, ≥6)" class="input-dark" required pattern="[A-Za-z0-9]{6,}">
            <input type="password" name="password" placeholder="Пароль (≥8 символов)" class="input-dark" required minlength="8">
            <input type="text" name="fio" placeholder="ФИО (только кириллица и пробелы)" class="input-dark" required pattern="[А-Яа-яЁё\s]+">
            <input type="text" name="number" placeholder="Телефон 8(ХХХ)ХХХ-ХХ-ХХ" class="input-dark" required pattern="8\(\d{3}\)\d{3}-\d{2}-\d{2}">
            <input type="email" name="email" placeholder="Email" class="input-dark" required>
            <button type="submit" class="btn-primary">Зарегистрироваться</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            <a href="login.php" style="color:white;">Уже есть аккаунт? Войти</a>
        </p>
    </div>
</div>
</body>
</html>