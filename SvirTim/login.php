<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Введите email и пароль';
    } else {
        $conn = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $conn->execute([$email]);
        $user = $conn->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Неверный email или пароль';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Dagestanovo.net</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bolshoyboxik">
        <header>
            <h1> Вход в систему</h1>
            <a href="index.php" class="btn">На главную</a>
        </header>

        <div class="auth-form">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn">Войти</button>
                <a href="registration.php" class="btn ">Нет аккаунта? Зарегистрироваться</a>
            </form>
        </div>
    </div>
</body>
</html>