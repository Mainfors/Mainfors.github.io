<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$isAdmin = ($_SESSION['user_role'] === 'admin');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ArtSpace | Главная</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="app-container">
    <div class="container">
        <h1>🎨 ArtSpace</h1>
        <p>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user_fio']); ?>!</p>
        
        <div class="slider-container">
            <div class="slider-images" id="sliderImages">
                <img src="images/slide1.jpg" alt="Мастер-класс" class="slider-img">
                <img src="images/slide2.jpg" alt="Творчество" class="slider-img">
                <img src="images/slide3.jpg" alt="Рисование" class="slider-img">
                <img src="images/slide4.jpg" alt="Дизайн" class="slider-img">
            </div>
            <button class="slider-btn prev" id="prevBtn">◀</button>
            <button class="slider-btn next" id="nextBtn">▶</button>
            <div class="dots" id="dots"></div>
            <div class="slider-caption" id="sliderCaption">🎨 Рисование: учимся выражать эмоции</div>
        </div>
        
        <div class="card">
            <h3>Рисование, лепка, дизайн и другие творческие мастер-классы. Запишись и развивай свой талант!</h3>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 16px;">
            <a href="new_request.php" class="btn-primary">📅 Записаться</a>
            <a href="my_requests.php" class="btn-outline">📋 Мои записи</a>
        </div>
        <?php if ($isAdmin): ?>
            <div style="margin-top: 20px;">
                <a href="admin.php" class="btn-primary" style="background:#333; color:white;">⚙️ Панель администратора</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="nav-bottom">
        <button class="nav-item active" onclick="location.href='dashboard.php'">🏠<span>Главная</span></button>
        <button class="nav-item" onclick="location.href='my_requests.php'">📋<span>Мои записи</span></button>
        <button class="nav-item" onclick="location.href='new_request.php'">✏️<span>Запись</span></button>
        <?php if ($isAdmin): ?><button class="nav-item" onclick="location.href='admin.php'">⚙️<span>Админ</span></button><?php endif; ?>
        <button class="nav-item" onclick="location.href='logout.php'">🚪<span>Выйти</span></button>
    </div>
</div>
<script>
    window.sliderCaptions = [
        "🎨 Рисование: раскрой свой талант на холсте",
        "🏺 Лепка: создавай формы своими руками",
        "💻 Дизайн: от идеи до макета",
        "💧 Акварель: лёгкость и прозрачность цвета"
    ];
</script>
<script src="script.js"></script>
</body>
</html>