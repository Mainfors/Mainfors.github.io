<?php
// auth/login.php
require_once __DIR__ . '/../config/database.php';

// Если пользователь уже авторизован, перенаправляем
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || empty($password)) {
        $error = 'Пожалуйста, заполните все поля';
    } else {
        try {
            $database = new Database();
            $db = $database->getConnection();

            $stmt = $db->prepare("SELECT id, name, email, password_hash, role FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Успешная авторизация
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                header('Location: ../index.php');
                exit;
            } else {
                $error = 'Неверный email или пароль';
            }
        } catch(PDOException $e) {
            $error = 'Ошибка сервера. Попробуйте позже.';
            error_log('Login error: ' . $e->getMessage());
        }
    }
    
    // Если есть ошибка, возвращаем на страницу с сообщением
    if ($error) {
        $_SESSION['login_error'] = $error;
        header('Location: ../index.php?error=login');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
?>