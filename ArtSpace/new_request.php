<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); 
    exit; 
}

// Проверяем, существует ли пользователь в БД (на случай сбоя сессии)
$stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
if (!$stmt->fetch()) {
    session_destroy();
    header('Location: login.php?error=session_expired');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $payment = $_POST['payment_type'];
    if (empty($date)) {
        $error = "Выберите дату";
    } else {
        $stmt = $pdo->prepare("INSERT INTO requests (user_id, name, date, payment_type, status) VALUES (?, ?, ?, ?, 'send')");
        if ($stmt->execute([$_SESSION['user_id'], $name, $date, $payment])) {
            header('Location: my_requests.php?success=1');
            exit;
        } else {
            $error = "Ошибка при сохранении: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Новая запись | ArtSpace</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Принудительно белый текст на странице новой записи */
        body, .container, h2, form, label, input, select, textarea, 
        .input-dark, .input-dark::placeholder, .btn-primary, 
        .radio-group, .radio-group label, .radio-group span {
            color: white !important;
        }
        /* Для селекта и инпутов дополнительно делаем фон тёмным, а текст белым */
        select, input, textarea {
            background-color: #1a1a1a !important;
            border-color: #444 !important;
        }
        select option {
            background-color: #1a1a1a;
            color: white;
        }
        /* Радиокнопки: белая обводка и белая точка при выборе */
        input[type="radio"] {
            accent-color: white;
            transform: scale(1.1);
            margin-right: 8px;
        }
        .btn-primary {
            background-color: white;
            color: #0a0a0a !important; /* сама кнопка остаётся контрастной */
        }
        .error {
            color: #ff8888 !important;
        }
    </style>
</head>
<body>
<div class="app-container">
    <div class="container">
        <h2>✏️ Новая запись</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="POST">
            <select name="name" class="input-dark" required>
                <option value="рисование">Рисование</option>
                <option value="лепка">Лепка</option>
                <option value="дизайн">Дизайн</option>
                <option value="акварель">Акварель</option>
                <option value="скетчинг">Скетчинг</option>
            </select>
            
            <input type="datetime-local" name="date" class="input-dark" required>
            
            <div class="radio-group" style="display: flex; gap: 20px; margin: 16px 0;">
                <label style="display: flex; align-items: center;">
                    <input type="radio" name="payment_type" value="cash" checked> Наличными
                </label>
                <label style="display: flex; align-items: center;">
                    <input type="radio" name="payment_type" value="transfer"> Перевод
                </label>
            </div>
            
            <button type="submit" class="btn-primary">Записаться</button>
        </form>
    </div>
    
    <div class="nav-bottom">
        <button class="nav-item" onclick="location.href='dashboard.php'">🏠<span>Главная</span></button>
        <button class="nav-item" onclick="location.href='my_requests.php'">📋<span>Мои записи</span></button>
        <button class="nav-item active" onclick="location.href='new_request.php'">✏️<span>Запись</span></button>
        <button class="nav-item" onclick="location.href='logout.php'">🚪<span>Выйти</span></button>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>