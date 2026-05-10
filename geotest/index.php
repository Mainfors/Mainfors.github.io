<?php
// index.php
require_once __DIR__ . '/config/database.php';

// Безопасная проверка сессии
$Logged = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userRole = $_SESSION['user_role'] ?? '';
$Admin = ($userRole === 'admin');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Географический Тест | Главная</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="box">
        <header>
            <h1>Тест по Географии</h1>
            <nav>
                <a href="index.php" class="active">Главная</a>
                <?php if ($Logged): ?>
                    <a href="test.php">Сценарии</a>
                    <a href="user/profile.php">Личный кабинет</a>
                    <?php if ($Admin): ?>
                        <a href="admin/index.php">Админ-панель</a>
                    <?php endif; ?>
                    <span class="userinfo"> <?= htmlspecialchars($userName) ?></span>
                    <a href="auth/logout.php" class="logout">Выйти</a>
                <?php else: ?>
                    <a href="javascript:void(0)" onclick="showLoginForm()">Войти</a>
                    <a href="javascript:void(0)" onclick="showRegisterForm()">Регистрация</a>
                <?php endif; ?>
            </nav>
        </header>

        <main>
            <?php if ($Logged): ?>
                <div class="welcome">
                    <h2>Добро пожаловать, <?= htmlspecialchars($userName) ?>!</h2>
                    <p>Выберите сценарий и проверьте свои знания по географии.</p>
                    <a href="test.php" class="btn">Перейти к тестам</a>
                </div>
            <?php else: ?>
                <div class="auth">
                    <div id="loginForm" class="form">
                        <h2>Вход в систему</h2>
                        <form id="loginFormElement" method="POST" action="auth/login.php">
                            <div class="form-group">
                                <label for="loginEmail">Email:</label>
                                <input type="email" id="loginEmail" name="email" required 
                                       placeholder="admin@geo.ru">
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Пароль:</label>
                                <input type="password" id="logPassword" name="password" required 
                                       placeholder="password">
                            </div>
                            <button type="submit" class="btn">Войти</button>
                        </form>
                        <div id="loginMessage" class="message"></div>
                        <p class="formak">
                            Нет аккаунта? 
                            <a href="javascript:void(0)" onclick="showRegisterForm()">Зарегистрироваться</a>
                        </p>
                    </div>

                    
                    <div id="registerForm" class="form" style="display: none;">
                        <h2>Регистрация</h2>
                        <form id="registerFormElement" method="POST" action="auth/register.php">
                            <div class="formak">
                                <label for="regName">Имя:</label>
                                <input type="text" id="regName" name="name" required minlength="2">
                            </div>
                            <div class="formak">
                                <label for="Email">Email:</label>
                                <input type="email" id="Email" name="email" required>
                            </div>
                            <div class="formak">
                                <label for="regPassword">Пароль:</label>
                                <input type="password" id="Password" name="password" required minlength="6">
                            </div>
                            <button type="submit" class="btn">Зарегистрироваться</button>
                        </form>
                        <div id="registerMessage" class="message"></div>
                        <p class="formfot">
                            Уже есть аккаунт? 
                            <a href="javascript:void(0)" onclick="showLoginForm()">Войти</a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php if (!$Logged): ?>
    <script src="js/auth.js"></script>
    <?php endif; ?>
</body>
</html>