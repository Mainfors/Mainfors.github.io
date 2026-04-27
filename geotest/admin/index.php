<?php
// admin/index.php
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Получение всех результатов
$results = $db->query("
    SELECT r.*, u.name as user_name, s.title as scenario_title 
    FROM results r 
    JOIN users u ON r.user_id = u.id 
    JOIN scenarios s ON r.scenario_id = s.id 
    ORDER BY r.passed_at DESC
")->fetchAll();

// Получение статистики
$totalUsers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalTests = $db->query("SELECT COUNT(*) FROM results")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>⚙️ Административная панель</h1>
            <nav>
                <a href="../index.php">Главная</a>
                <a href="../auth/logout.php">Выйти</a>
            </nav>
        </header>

        <main>
            <div class="stats-cards">
                <div class="stat-card">
                    <h3>Пользователи</h3>
                    <p class="stat-number"><?= $totalUsers ?></p>
                </div>
                <div class="stat-card">
                    <h3>Пройдено тестов</h3>
                    <p class="stat-number"><?= $totalTests ?></p>
                </div>
            </div>

            <h2>Результаты пользователей</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Пользователь</th>
                        <th>Сценарий</th>
                        <th>Баллы</th>
                        <th>Результат</th>
                        <th>Дата</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= htmlspecialchars($result['user_name']) ?></td>
                            <td><?= htmlspecialchars($result['scenario_title']) ?></td>
                            <td><?= $result['total_score'] ?></td>
                            <td><?= htmlspecialchars($result['result_label']) ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($result['passed_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>