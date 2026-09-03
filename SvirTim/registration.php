<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'user'; 
    
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Все поля обязательны для заполнения';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен быть не менее 6 символов';
    } else {
        
        $conn = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $conn->execute([$email]);
        if ($conn->fetch()) {
            $error = 'Пользователь с таким email уже существует';
        } else {
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            
            $conn = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            if ($conn->execute([$name, $email, $hashedPassword, $role])) {
                $success = 'Регистрация успешна! Теперь вы можете войти.';
               
                $name = $email = '';
            } else {
                $error = 'Ошибка регистрации. Попробуйте позже.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Dagestanovo.net</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bolshoyboxik">
        <header>
            <h1> Регистрация</h1>
            <a href="index.php" class="btn btn-outline">На главную</a>
        </header>

        <div class="auth-form">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль (мин. 6 символов)</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                <a href="login.php" class="btn btn-outline">Уже есть аккаунт? Войти</a>
            </form>
        </div>
    </div>
</body>
</html>