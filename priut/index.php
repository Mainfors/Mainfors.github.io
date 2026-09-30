<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Приют для животных</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
    <div class="container headerinner">
        <a href="index.php" class="logo">Приют имени Свиридова</a>
        <nav class="nav">
            <a href="index.php" class="navlink">Главная</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="UserPage.php" class="navlink">Кабинет</a>
                <a href="UserPage.php?logout=1" class="navlink">Выход</a>
            <?php else: ?>
                <a href="auth.php" class="navlink">Вход</a>
                <a href="reg.php" class="navlink">Регистрация</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="main">
    <div class="container">
        <h1 class="title">Приют для животных</h1>
        <p class="text">
            Мы занимаемся поиском хозяина для маленьких верных зверушек. Каждый наш подопечный —
            это маленькое существо, которое ждёт своего человека. Мы лечим, кормим и заботимся
            о животных, оказавшихся без дома, и помогаем им найти любящую семью.
        </p>
        <p class="text">
            Если вы хотите подарить дом коту, собаке, кролику или другому зверьку — зарегистрируйтесь
            и посмотрите наших подопечных в личном кабинете.
        </p>

        <h2 class="subtitle">Как мы работаем</h2>
        <div class="grid">
            <div class="card">
                <h3 class="subtitle">Спасаем</h3>
                <p class="text">Забираем животных с улицы и из трудных ситуаций.</p>
            </div>
            <div class="card">
                <h3 class="subtitle">Заботимся</h3>
                <p class="text">Лечим, кормим и даём животным тепло и уход.</p>
            </div>
            <div class="card">
                <h3 class="subtitle">Ищем дом</h3>
                <p class="text">Подбираем каждому зверьку заботливого хозяина.</p>
            </div>
        </div>
         <h2 class="subtitle">Наши подопечные</h2>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p class="text">Приют для животных</p>
    </div>
</footer>
</body>
</html>