<?php 
session_start();
require_once 'db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: authPage.php');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM `choosing-service` WHERE user_id = ? ORDER BY date_visit DESC");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои услуги</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2> Мои услуги</h2>
    
    <nav>
        <a href="zay.php">Забронировать</a>
        <a href="userPage.php">Мои услуги</a>
        <a href="php/logOut.php">Выход</a>
    </nav>

    <?php if (empty($bookings)): ?>
        <p style="text-align:center;">У вас пока нет услуг</p>
    <?php else: ?>
        <?php foreach ($bookings as $b): ?>
            <div class = "zya">
                <p><b>Автомобиль:</b> <?= htmlspecialchars($b['auto_name']) ?></p>
                <p><b>Дата:</b> <?= date('d.m.Y H:i', strtotime($b['date_visit'])) ?></p>
                <p><b>Вид услуги:</b> <?= htmlspecialchars($b['purpose']) ?></p>
                <p><b>Способ оплаты:</b> <?= htmlspecialchars($b['payment_method']) ?></p>
                <p><b>Статус:</b> <?= htmlspecialchars($b['status']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>