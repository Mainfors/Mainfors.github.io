<?php
// user/profile.php
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

$userId = $_SESSION['user_id'];

// Получаем результаты пользователя
$stmt = $db->prepare("
    SELECT r.*, s.title as scenario_title 
    FROM results r 
    JOIN scenarios s ON r.scenario_id = s.id 
    WHERE r.user_id = :uid 
    ORDER BY r.passed_at DESC
");
$stmt->execute([':uid' => $userId]);
$results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>👤 Личный кабинет</h1>
            <nav>
                <a href="../index.php">Главная</a>
                <a href="../test.php">Тесты</a>
                <a href="../auth/logout.php">Выйти</a>
            </nav>
        </header>

        <main>
            <h2>Здравствуйте, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
            
            <h3>Ваши результаты:</h3>
            <?php if (empty($results)): ?>
                <p>Вы еще не прошли ни одного теста.</p>
            <?php else: ?>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>Сценарий</th>
                            <th>Дата</th>
                            <th>Баллы</th>
                            <th>Результат</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $result): ?>
                            <tr>
                                <td><?= htmlspecialchars($result['scenario_title']) ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($result['passed_at'])) ?></td>
                                <td><?= $result['total_score'] ?></td>
                                <td><?= htmlspecialchars($result['result_label']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>