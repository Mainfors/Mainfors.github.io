<?php 
session_start();
require_once 'db/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: authPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    
    $auto_name = $_POST['auto_name'] ?? '';
    $service = $_POST['service'] ?? '';
    $date_visit = $_POST['date_visit'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    if (!$auto_name || !$service || !$date_visit || !$payment_method) {
        die('Заполните все обязательные поля');
    }

    $stmt = $conn->prepare("INSERT INTO `choosing-service` (user_id, auto_name, service, date_visit, purpose, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, 'Заявка подана')");
    
    try {
        $stmt->execute([$user_id, $auto_name, $service, $date_visit, $purpose, $payment_method]);
        header("Location: userPage.php?stat=success");
        exit();
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выбрать услугу</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container1">
    <h2>Выбрать услугу</h2>
    
    <nav>
        <a href="zay.php">Услуги</a>
        <a href="userPage.php">Мои брони</a>
        <a href="php/logOut.php">Выход</a>
    </nav>

    <form method="POST" style="max-width: 500px; margin: 20px auto;">
        <label>Выберите услугу:</label>
        <select name="service" required>
            <option value="Починить">Починить машину</option>
            <option value="Помыть">Помыть машину</option>
            <option value="Продать">Продать машину</option>
        </select>
        
        <label>Марка автомобиля:</label>
        <input type="text" name="auto_name" placeholder="Например: Hyundai Solaris" required>

        <label>Дата и время:</label>
        <input type="datetime-local" name="date_visit" required>

        <label>Способ оплаты:</label>
        <select name="payment_method" required>
            <option value="Наличные">Наличные</option>
            <option value="Банковская карта">Банковская карта</option>
        </select>

        <button type="submit">Забронировать</button>
    </form>
</div>
</body>
</html>