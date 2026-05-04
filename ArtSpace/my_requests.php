<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'], $_POST['request_id'])) {
    $review = trim($_POST['review']);
    $req_id = $_POST['request_id'];
    if (!empty($review)) {
        $stmt = $pdo->prepare("UPDATE requests SET review = ? WHERE id = ? AND user_id = ? AND status = 'complete'");
        $stmt->execute([$review, $req_id, $user_id]);
    }
    header('Location: my_requests.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM requests WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$requests = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои записи | ArtSpace</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .card, .card * { color: white !important; }
        .card p, .card h3, .card div { color: white !important; }
        .badge { color: white !important; background: #2c2c2c; }
    </style>
</head>
<body>
<div class="app-container">
    <div class="container">
        <h2>📋 Мои записи</h2>
        <?php if (empty($requests)): ?>
            <p>У вас пока нет записей</p>
        <?php else: foreach ($requests as $req): ?>
            <div class="card">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 style="color:white;"><?= htmlspecialchars($req['name']) ?></h3>
                    <span class="badge badge-<?= $req['status'] ?>">
                        <?php if ($req['status'] == 'send'): ?>Заявка подана
                        <?php elseif ($req['status'] == 'confirm'): ?>Участие подтверждено
                        <?php else: ?>Мастер-класс проведён<?php endif; ?>
                    </span>
                </div>
                <p style="color:white;">📅 <?= date('d.m.Y H:i', strtotime($req['date'])) ?></p>
                <p style="color:white;">💳 <?= $req['payment_type'] == 'cash' ? 'Наличные' : 'Перевод' ?></p>
                <?php if ($req['status'] == 'complete'): ?>
                    <?php if (!empty($req['review'])): ?>
                        <p style="color:white;"><strong>Ваш отзыв:</strong> <?= htmlspecialchars($req['review']) ?></p>
                    <?php else: ?>
                        <form method="POST">
                            <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                            <textarea name="review" class="input-dark" rows="2" placeholder="Оставьте отзыв о мастер-классе..." style="color:white;"></textarea>
                            <button type="submit" class="btn-primary">Отправить отзыв</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; endif; ?>
    </div>
    <div class="nav-bottom">
        <button class="nav-item" onclick="location.href='dashboard.php'">🏠<span>Главная</span></button>
        <button class="nav-item active" onclick="location.href='my_requests.php'">📋<span>Мои записи</span></button>
        <button class="nav-item" onclick="location.href='new_request.php'">✏️<span>Запись</span></button>
        <button class="nav-item" onclick="location.href='logout.php'">🚪<span>Выйти</span></button>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>