<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit();
}
session_start();

$login = trim($_POST['login']);
$password = $_POST['password'];
$fio = trim($_POST['fio']);
$tel = trim($_POST['tel']);
$email = trim($_POST['email']);

if(empty($login) or empty($password) or empty($email) or empty($tel) or empty($fio)){
    $_SESSION['message'] = "Все поля должны быть заполнены";
    header("Location: ../index.php?stat=error");
    exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Некорректный Email!";
    header("Location: ../index.php?stat=error");
    exit();
}

require_once '../db/connection.php';


$check = $conn->prepare("SELECT id FROM users WHERE login = :login OR email = :email");
$check->execute([':login' => $login, ':email' => $email]);

if ($check->fetch()) {
    $_SESSION['message'] = "Такой логин или email уже существует!";
    header("Location: ../index.php?stat=error");
    exit();
}

$checkUser = $conn->prepare("INSERT INTO users (login, password, email, tel, fio, role) VALUES (:login, :pass, :email, :tel, :fio, 'user')");
$checkUser->execute([
    ':login' => $login,
    ':pass' => password_hash($password, PASSWORD_DEFAULT),
    ':email' => $email,
    ':tel' => $tel,
    ':fio' => $fio
]);

$_SESSION['message'] = "Успешная регистрация!";
header("Location: ../authPage.php?stat=ok");
exit();
?>