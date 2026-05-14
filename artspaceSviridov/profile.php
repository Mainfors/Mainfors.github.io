<?php
require_once 'database/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: php/autorisation.php");
}

$user_id = $_SESSION['user_id'];

$dab = "SELECT * FROM requests WHERE user_id='$user_id'";

$result = $conn->query($dab);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Личный кабинет</title>

<link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>

<h1>Личный кабинет</h1>

<nav>
<a href="php/request.php">Запись</a>
<a href="php/logout.php">Выйти</a>
</nav>

</header>

<div class="requestik">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card">

<h3><?= $row['requests'] ?></h3>

<p>Дата: <?= $row['visit_date'] ?></p>

<p>Статус: <?= $row['status'] ?></p>

</div>

<?php } ?>

</div>

</body>
</html>