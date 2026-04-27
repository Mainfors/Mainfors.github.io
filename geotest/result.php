<?php
// result.php
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

$userId = $_SESSION['user_id'];
$scenarioId = $_POST['scenario_id'] ?? null;
$answers = $_POST['answers'] ?? [];

if (!$scenarioId || empty($answers)) {
    die("Ошибка: не получены ответы");
}

try {
    $db->beginTransaction();

    $totalScore = 0;
    
    // Сохраняем ответы пользователя
    $insertAnswer = $db->prepare("INSERT INTO user_answers (user_id, scenario_id, question_id, answer_id) VALUES (:uid, :sid, :qid, :aid)");
    
    foreach ($answers as $questionId => $answerId) {
        // Получаем балл за ответ
        $stmt = $db->prepare("SELECT score FROM answers WHERE id = :aid AND question_id = :qid");
        $stmt->execute([':aid' => $answerId, ':qid' => $questionId]);
        $answer = $stmt->fetch();
        
        if ($answer) {
            $totalScore += $answer['score'];
        }
        
        $insertAnswer->execute([
            ':uid' => $userId,
            ':sid' => $scenarioId,
            ':qid' => $questionId,
            ':aid' => $answerId
        ]);
    }

    // Определяем результат
    if ($totalScore <= 25) {
        $resultLabel = 'Начинающий географ';
    } elseif ($totalScore <= 55) {
        $resultLabel = 'Знаток среднего уровня';
    } else {
        $resultLabel = 'Продвинутый эксперт';
    }

    // Сохраняем результат
    $stmt = $db->prepare("INSERT INTO results (user_id, scenario_id, total_score, result_label) VALUES (:uid, :sid, :score, :label)");
    $stmt->execute([
        ':uid' => $userId,
        ':sid' => $scenarioId,
        ':score' => $totalScore,
        ':label' => $resultLabel
    ]);

    $db->commit();
    
    // Получаем информацию о сценарии
    $stmt = $db->prepare("SELECT title FROM scenarios WHERE id = :id");
    $stmt->execute([':id' => $scenarioId]);
    $scenario = $stmt->fetch();

} catch (Exception $e) {
    $db->rollBack();
    die("Ошибка при сохранении результатов: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат теста</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>🎉 Результат теста</h1>
            <nav>
                <a href="index.php">Главная</a>
                <a href="user/profile.php">Личный кабинет</a>
            </nav>
        </header>

        <main>
            <div class="result-card">
                <h2><?= htmlspecialchars($scenario['title']) ?></h2>
                <div class="result-score">
                    <span class="score-number"><?= $totalScore ?></span>
                    <span class="score-unit">баллов</span>
                </div>
                <div class="result-label <?= str_replace(' ', '-', strtolower($resultLabel)) ?>">
                    <?= htmlspecialchars($resultLabel) ?>
                </div>
                <a href="test.php" class="btn btn-primary">Пройти другой тест</a>
            </div>
        </main>
    </div>
</body>
</html>