<?php
session_start();
require_once 'db.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';


$cabinets = $pdo->query("SELECT * FROM cabinets")->fetchAll();


$conn = $pdo->prepare("
    SELECT b.*, c.name as cabinet_name 
    FROM bookings b 
    JOIN cabinets c ON b.cabinet_id = c.id 
    WHERE b.user_id = ? 
    ORDER BY b.created_at DESC
");
$conn->execute([$user_id]);
$bookings = $conn->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $cabinet_id = $_POST['cabinet_id'];
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
   
    $conn = $pdo->prepare("
        SELECT * FROM bookings 
        WHERE cabinet_id = ? AND booking_date = ? 
        AND status != 'rejected'
        AND ((start_time <= ? AND end_time > ?) OR (start_time < ? AND end_time >= ?) OR (start_time >= ? AND end_time <= ?))
    ");
    $conn->execute([$cabinet_id, $booking_date, $start_time, $end_time, $start_time, $end_time, $start_time, $end_time]);
    
    if ($conn->fetch()) {
        $error = 'Этот кабинет уже занят в выбранное время';
    } else {
        $conn = $pdo->prepare("INSERT INTO bookings (user_id, cabinet_id, booking_date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        if ($conn->execute([$user_id, $cabinet_id, $booking_date, $start_time, $end_time])) {
            $success = 'Заявка успешно создана! Ожидайте подтверждения администратора.';
        } else {
            $error = 'Ошибка создания заявки';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронирования - Dagestanovo.net</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bolshoyboxik">
        <header>
            <h1> Бронирования</h1>
            <div class="auth-buttons">
                <span class="user-name"> <?php echo $_SESSION['user_name']; ?></span>
                <a href="logout.php" class="btn btn-danger">Выйти</a>
            </div>
        </header>

        <nav class="main-nav">
            <a href="index.php">Паспорт проекта</a>
            <a href="bookings.php" class="active"> Бронирования</a>
            <?php if($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php"> Админ-панель</a>
            <?php endif; ?>
        </nav>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <section class="booking-form">
            <h3> Создать заявку</h3>
            <form method="POST">
                <input type="hidden" name="action" value="create">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="cabinet_id">Выберите кабинет</label>
                        <select id="cabinet_id" name="cabinet_id" required>
                            <option value="">Выберите кабинет</option>
                            <?php foreach ($cabinets as $cabinet): ?>
                                <option value="<?php echo $cabinet['id']; ?>">
                                    <?php echo htmlspecialchars($cabinet['name']); ?> 
                                    (<?php echo htmlspecialchars($cabinet['location']); ?>, 
                                    вместимость: <?php echo $cabinet['capacity']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="booking_date">Дата</label>
                        <input type="date" id="booking_date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_time">Время начала</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_time">Время окончания</label>
                        <input type="time" id="end_time" name="end_time" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Забронировать</button>
            </form>
        </section>

        <section class="my-bookings">
            <h3>Мои заявки</h3>
            <?php if (empty($bookings)): ?>
                <p>У вас пока нет заявок</p>
            <?php else: ?>
                <table class="passport-table">
                    <thead>
                        <tr>
                            <th>Кабинет</th>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['cabinet_name']); ?></td>
                                <td><?php echo date('d.m.Y', strtotime($booking['booking_date'])); ?></td>
                                <td><?php echo substr($booking['start_time'], 0, 5); ?> - <?php echo substr($booking['end_time'], 0, 5); ?></td>
                                <td>
                                    <?php if ($booking['status'] === 'pending'): ?>
                                        <span class="badge badge-pending">На рассмотрении</span>
                                    <?php elseif ($booking['status'] === 'approved'): ?>
                                        <span class="badge badge-approved">Одобрено</span>
                                    <?php else: ?>
                                        <span class="badge badge-rejected">Отклонено</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>