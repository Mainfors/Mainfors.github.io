<?php
// test.php
require_once __DIR__ . '/config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Получение всех сценариев
$scenarios = $db->query("SELECT * FROM scenarios ORDER BY created_at DESC")->fetchAll();

// Обработка запуска теста
$currentScenario = null;
$questions = [];
if (isset($_GET['scenario_id'])) {
    $stmt = $db->prepare("SELECT * FROM scenarios WHERE id = :id");
    $stmt->execute([':id' => $_GET['scenario_id']]);
    $currentScenario = $stmt->fetch();
    
    if ($currentScenario) {
        $stmt = $db->prepare("SELECT * FROM questions WHERE scenario_id = :sid ORDER BY question_order");
        $stmt->execute([':sid' => $currentScenario['id']]);
        $questions = $stmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Прохождение теста</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>📝 Тестирование</h1>
            <nav>
                <a href="index.php">Главная</a>
                <a href="user/profile.php">Личный кабинет</a>
            </nav>
        </header>

        <main>
            <?php if (!$currentScenario): ?>
                <h2>Выберите сценарий</h2>
                <div class="scenarios-grid">
                    <?php foreach ($scenarios as $scenario): ?>
                        <div class="scenario-card">
                            <h3><?= htmlspecialchars($scenario['title']) ?></h3>
                            <p><?= htmlspecialchars($scenario['description']) ?></p>
                            <span class="badge"><?= htmlspecialchars($scenario['category']) ?></span>
                            <a href="test.php?scenario_id=<?= $scenario['id'] ?>" class="btn btn-primary">Начать тест</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <form action="result.php" method="POST" id="testForm">
                    <input type="hidden" name="scenario_id" value="<?= $currentScenario['id'] ?>">
                    <h2><?= htmlspecialchars($currentScenario['title']) ?></h2>
                    <?php foreach ($questions as $index => $question): 
                        $stmt = $db->prepare("SELECT * FROM answers WHERE question_id = :qid");
                        $stmt->execute([':qid' => $question['id']]);
                        $answers = $stmt->fetchAll();
                    ?>
                        <div class="question-block">
                            <h3>Вопрос <?= $index + 1 ?>: <?= htmlspecialchars($question['question_text']) ?></h3>
                            <?php foreach ($answers as $answer): ?>
                                <label class="answer-option">
                                    <input type="radio" name="answers[<?= $question['id'] ?>]" value="<?= $answer['id'] ?>" required>
                                    <?= htmlspecialchars($answer['answer_text']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary btn-large">Завершить тест</button>
                </form>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>