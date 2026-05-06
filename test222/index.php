<?php

$conn = new PDO ("mysql:host=localhost;dbname=yniky;charset=utf8",
    "root", "");

$limit = 4;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$userList = $conn->prepare("
    SELECT * FROM users
    ORDER BY id
    LIMIT :limit OFFSET :offset
");

$userList->bindValue(':limit', $limit, PDO::PARAM_INT);
$userList->bindValue(':offset', $offset, PDO::PARAM_INT);

$userList->execute();

$users = $userList->fetch();

$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

$totalPages = ceil($totalUsers / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛАГИНАЦИЯ</title>
</head>
<body>
    
    <? foreach ($users as $user): ?>
        <div class="user">
            <p>id: <?= htmlspecialchars($user['id']) ?></p>
            <p>login: <?=  htmlspecialchars($user['login']) ?></p>
        </div>
        <? endforeach; ?>

<div class="pagination">
<? for ($i = 1; $i <= $totalPages; $i++): ?>

    <? if ($i == page): ?>
        <span class="active"><?=  $i ?></span>
    <? else: ?>
        <a href="?page=<?= $i ?>"><?=  $i ?></a>
    <? endif; ?>

<? endfor; ?>
</div>

</body>
</html>