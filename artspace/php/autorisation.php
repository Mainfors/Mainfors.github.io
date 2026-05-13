<?php
include '../database/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($login == "ArtAdmin" && $password == "Creative") {

        $_SESSION['admin'] = true;

        header("Location: admin.php");
    }

    $dab = "SELECT * FROM users WHERE login='$login'";

    $result = $conn->query($dab);

    if ($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];

            header("Location: ../profile.php");

        } else {
            $error = "Неверный пароль";
        }

    } else {
        $error = "Пользователь не найден";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Авторизация</title>

<link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="formik">
    <h2>Авторизация</h2>
        <form method="POST">
            <input type="text" name="login" placeholder="Логин" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
            <p class="error"><?= $error ?></p>
        </form>
            <a href="registration.php">Еще не зарегистрированы? Регистрация</a>
    </div>
</body>
</html>