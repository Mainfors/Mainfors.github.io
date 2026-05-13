<?php
include '../database/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный email";
    }

    else {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $dab = "INSERT INTO users(login,password,name,phone,email)
                VALUES('$login','$hash','$name','$phone','$email')";

        if ($conn->query($dab)) {
            header("Location: ../php/autorisation.php");
        } else {
            $error = "Ошибка регистрации";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Регистрация</title>

<link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="formik">
        <h2>Регистрация</h2>
        <form method="POST">
            <input type="text" name="login" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <input type="text" name="fullname" placeholder="ФИО" required>
            <input type="text" name="phone" placeholder="8(999)999-99-99" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Зарегистрироваться</button>
            <p class="error"><?= $error ?></p>
        </form>
        <a href="autorisation.php">Назад к авторизации</a>
    </div>
</body>
</html>