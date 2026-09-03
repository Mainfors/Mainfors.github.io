<!-- логин и пароль ддя админ : admin123 admin-->
<?php
session_start();
require_once 'db/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: authPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
    $id = (int)$_POST['order_id'];
    $status = $_POST['new_status'];
    if (in_array($status, ['Новая', 'Принята в работу', 'Работа завершена'])) {
        $stmt = $conn->prepare("UPDATE `choosing-service` SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }
    header('Location: admin.php');
    exit();
}

$all = $conn->query("SELECT b.*, u.fio, u.tel FROM `choosing-service` b JOIN users u ON b.user_id = u.id ORDER BY b.date_visit DESC");
$bookings = $all->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Админ-панель</h2>
    <nav>
        <a href="admin.php">Заявки</a>
        <a href="php/logOut.php">Выход</a>
    </nav>

    <?php if (empty($bookings)): ?>
        <p>Заявок пока нет.</p>
    <?php else: ?>
        <?php foreach ($bookings as $row): ?>
            <div class="admin-card">
                <b>Заявка <?= $row['id'] ?></b> — <?= htmlspecialchars($row['status']) ?>
                <hr>
                <p><b>Клиент:</b> <?= htmlspecialchars($row['fio']) ?> (<?= htmlspecialchars($row['tel']) ?>)</p>
                <p><b>Авто:</b> <?= htmlspecialchars($row['auto_name']) ?></p>
                <p><b>Услуга:</b> <?= htmlspecialchars($row['service']) ?></p>
                <p><b>Дата:</b> <?= date('d.m.Y H:i', strtotime($row['date_visit'])) ?></p>
                <p><b>Оплата:</b> <?= htmlspecialchars($row['payment_method']) ?></p>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                    <select name="new_status">
                        <option value="Новая" <?= $row['status']==='Новая'?'selected':'' ?>>Новая</option>
                        <option value="Принята в работу" <?= $row['status']==='Принята в работу'?'selected':'' ?>>Принята в работу</option>
                        <option value="Работа завершена" <?= $row['status']==='Работа завершена'?'selected':'' ?>>Работа завершена</option>
                    </select>
                    <button type="submit">Изменить</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>