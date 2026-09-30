<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

$conn = $pdo->prepare('SELECT username, email FROM users WHERE id = ?');
$conn->execute([$_SESSION['user_id']]);
$user = $conn->fetch();

if (!$user) {
    session_destroy();
    header('Location: auth.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
    <div class="container headerinner">
        <a href="index.php" class="logo">Приют имени Свиридова</a>
        <nav class="nav">
            <a href="index.php" class="navlink">Главная</a>
            <a href="UserPage.php" class="navlink">Кабинет</a>
            <a href="UserPage.php?logout=1" class="navlink">Выход</a>
        </nav>
    </div>
</header>

<main class="main">
    <div class="container">
        <h1 class="title">Личный кабинет</h1>

        <div class="card">
            <p class="text">Имя пользователя: <?= htmlspecialchars($user['username']) ?></p>
            <p class="text">Email: <?= htmlspecialchars($user['email']) ?></p>
        </div>

        <h2 class="subtitle">Наши подопечные</h2>
        <div class="grid">
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p class="text">Приют для животных</p>
    </div>
</footer>
</body>
</hconn