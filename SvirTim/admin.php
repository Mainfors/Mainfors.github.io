<?php
session_start();
require_once 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    if ($stmt->execute([$new_status, $booking_id])) {
        $success = 'Статус заявки обновлен';
    } else {
        $error = 'Ошибка обновления статуса';
    }
}


$bookings = $pdo->query("
    SELECT b.*, u.name as user_name, u.email as user_email, c.name as cabinet_name 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN cabinets c ON b.cabinet_id = c.id 
    ORDER BY b.created_at DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - Dagestanovo.net</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1> Админ-панель</h1>
            <div class="auth-buttons">
                <span class="user-name"> <?php echo $_SESSION['user_name']; ?> (Администратор)</span>
                <a href="logout.php" class="btn btn-danger">Выйти</a>
            </div>
        </header>

        <nav class="main-nav">
            <a href="index.php"> Паспорт проекта</a>
            <a href="bookings.php"> Бронирования</a>
            <a href="admin.php" class="active"> Админ-панель</a>
        </nav>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <section>
            <h3> Управление заявками</h3>
            
            <?php if (empty($bookings)): ?>
                <p>Нет заявок для обработки</p>
            <?php else: ?>
                <table class="passport-table">
                    <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th>Кабинет</th>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($booking['user_name']); ?><br>
                                    <small style="color: #666;"><?php echo htmlspecialchars($booking['user_email']); ?></small>
                                </td>
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
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                        <select name="status" onchange="this.form.submit()">
                                            <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>В рассмотрении</option>
                                            <option value="approved" <?php echo $booking['status'] === 'approved' ? 'selected' : ''; ?>>Одобрено</option>
                                            <option value="rejected" <?php echo $booking['status'] === 'rejected' ? 'selected' : ''; ?>>Отклонено</option>
                                        </select>
                                    </form>
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