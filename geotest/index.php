<?php
// index.php
require_once __DIR__ . '/config/database.php';

// Безопасная проверка сессии
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userRole = $_SESSION['user_role'] ?? '';
$isAdmin = ($userRole === 'admin');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гео-Тест | Главная</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🌍 Тест по Географии</h1>
            <nav>
                <a href="index.php" class="active">Главная</a>
                <?php if ($isLoggedIn): ?>
                    <a href="test.php">Сценарии</a>
                    <a href="user/profile.php">Личный кабинет</a>
                    <?php if ($isAdmin): ?>
                        <a href="admin/index.php">Админ-панель</a>
                    <?php endif; ?>
                    <span class="user-info">👤 <?= htmlspecialchars($userName) ?></span>
                    <a href="auth/logout.php" class="btn-logout">Выйти</a>
                <?php else: ?>
                    <a href="javascript:void(0)" onclick="showLoginForm()">Войти</a>
                    <a href="javascript:void(0)" onclick="showRegisterForm()">Регистрация</a>
                <?php endif; ?>
            </nav>
        </header>

        <main>
            <?php if ($isLoggedIn): ?>
                <div class="welcome-card">
                    <h2>Добро пожаловать, <?= htmlspecialchars($userName) ?>!</h2>
                    <p>Выберите сценарий и проверьте свои знания по географии.</p>
                    <a href="test.php" class="btn btn-primary">Перейти к тестам</a>
                </div>
            <?php else: ?>
                <div class="auth-container">
                    <!-- Форма входа -->
                    <div id="loginForm" class="form-card">
                        <h2>Вход в систему</h2>
                        <form id="loginFormElement" method="POST" action="auth/login.php">
                            <div class="form-group">
                                <label for="loginEmail">Email:</label>
                                <input type="email" id="loginEmail" name="email" required 
                                       placeholder="admin@geo.ru">
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Пароль:</label>
                                <input type="password" id="loginPassword" name="password" required 
                                       placeholder="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Войти</button>
                        </form>
                        <div id="loginMessage" class="message"></div>
                        <p class="form-footer">
                            Нет аккаунта? 
                            <a href="javascript:void(0)" onclick="showRegisterForm()">Зарегистрироваться</a>
                        </p>
                    </div>

                    <!-- Форма регистрации -->
                    <div id="registerForm" class="form-card" style="display: none;">
                        <h2>Регистрация</h2>
                        <form id="registerFormElement" method="POST" action="auth/register.php">
                            <div class="form-group">
                                <label for="regName">Имя:</label>
                                <input type="text" id="regName" name="name" required minlength="2">
                            </div>
                            <div class="form-group">
                                <label for="regEmail">Email:</label>
                                <input type="email" id="regEmail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="regPassword">Пароль:</label>
                                <input type="password" id="regPassword" name="password" required minlength="6">
                            </div>
                            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                        </form>
                        <div id="registerMessage" class="message"></div>
                        <p class="form-footer">
                            Уже есть аккаунт? 
                            <a href="javascript:void(0)" onclick="showLoginForm()">Войти</a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <?php if (!$isLoggedIn): ?>
    <!-- Переносим JavaScript в конец для лучшей производительности -->
    <script src="js/auth.js"></script>
    <?php endif; ?>
</body>
</html>