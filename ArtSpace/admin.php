<?php
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') { 
    header('Location: login.php'); 
    exit; 
}

try {
    $pdo->exec("ALTER TABLE requests ADD COLUMN review TEXT NULL");
} catch (PDOException $e) {
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['status'])) {
    $status = $_POST['status'];
    $rid = $_POST['request_id'];
    if (in_array($status, ['send','confirm','complete'])) {
        $stmt = $pdo->prepare("UPDATE requests SET status = ? WHERE id = ?");
        $stmt->execute([$status, $rid]);
    }
    header('Location: admin.php');
    exit;
}

$stmt = $pdo->query("
    SELECT r.*, u.login, u.fio 
    FROM requests r 
    JOIN users u ON r.user_id = u.id 
    ORDER BY r.date DESC
");
$all_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ панель | ArtSpace</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container, .card, .card * {
            color: white !important;
        }
        .btn-outline {
            color: white !important;
            border-color: #666;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
<div class="app-container">
    <div class="container">
        <h2>⚙️ Панель администратора</h2>
        <?php if (empty($all_requests)): ?>
            <p>Нет ни одной записи.</p>
        <?php else: foreach ($all_requests as $req): ?>
            <div class="card">
                <h3><?= htmlspecialchars($req['name']) ?></h3>
                <p>Пользователь: <?= htmlspecialchars($req['fio']) ?> (<?= htmlspecialchars($req['login']) ?>)</p>
                <p>📅 <?= date('d.m.Y H:i', strtotime($req['date'])) ?></p>
                <p>💳 <?= $req['payment_type'] == 'cash' ? 'Наличные' : 'Перевод' ?></p>
                
                <?php if (!empty($req['review'])): ?>
                    <p>⭐ Отзыв: <?= htmlspecialchars($req['review']) ?></p>
                <?php endif; ?>
                
                <form method="POST" style="display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap;">
                    <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                    <button type="submit" name="status" value="send" class="btn-outline" style="padding: 8px 12px;">Заявка подана</button>
                    <button type="submit" name="status" value="confirm" class="btn-outline" style="padding: 8px 12px;">Подтверждено</button>
                    <button type="submit" name="status" value="complete" class="btn-outline" style="padding: 8px 12px;">Проведён</button>
                </form>
            </div>
        <?php endforeach; endif; ?>
    </div>
    <div class="nav-bottom">
        <button class="nav-item" onclick="location.href='dashboard.php'">🏠<span>Главная</span></button>
        <button class="nav-item" onclick="location.href='my_requests.php'">📋<span>Мои записи</span></button>
        <button class="nav-item" onclick="location.href='new_request.php'">✏️<span>Запись</span></button>
        <button class="nav-item active" onclick="location.href='admin.php'">⚙️<span>Админ</span></button>
        <button class="nav-item" onclick="location.href='logout.php'">🚪<span>Выйти</span></button>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>