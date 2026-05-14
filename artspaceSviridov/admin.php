<?php
require_once 'database/db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: php/authorisation.php");
}

if (isset($_POST['status'])) {

    $id = $_POST['id'];
    $status = $_POST['status'];

    $conn->query("UPDATE requests SET status='$status' WHERE id='$id'");
}

$result = $conn->query("
SELECT requests.*, users.name
FROM requests
JOIN users ON requests.user_id = users.id
");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Админ панель</title>

<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Панель администратора</h1>

<div class="cards">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card">

<h3><?= $row['name'] ?></h3>

<p><?= $row['requests'] ?></p>

<p><?= $row['visit_date'] ?></p>

<form method="POST">

<input type="hidden" name="id" value="<?= $row['id'] ?>">

<select name="status">

<option>Заявка подана</option>
<option>Участие подтверждено</option>
<option>Мастер-класс проведён</option>

</select>

<button>Изменить</button>

</form>
<nav>
    <a href="php/logout.php">Выйти</a>
</nav>
</div>

<?php } ?>

</div>

</body>
</html>