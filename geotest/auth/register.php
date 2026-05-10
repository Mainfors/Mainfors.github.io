<?php
// auth/register.php
require_once __DIR__ . '/../config/database.php';

// Если пользователь уже авторизован
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Валидация
    $errors = [];
    if (empty($name) || strlen($name) < 2) {
        $errors[] = 'Имя должно содержать минимум 2 символа';
    }
    if (!$email) {
        $errors[] = 'Некорректный email';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Пароль должен содержать минимум 6 символов';
    }

    if (!empty($errors)) {
        $error = implode('. ', $errors);
    } else {
        try {
            $database = new Database();
            $db = $database->getConnection();

            
            $check = $db->prepare("SELECT id FROM users WHERE email = :email");
            $check->execute([':email' => $email]);
            
            if ($check->fetch()) {
                $error = 'Пользователь с таким email уже существует';
            } else {
                
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                
               
                $insert = $db->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, 'user')");
                $insert->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':password_hash' => $passwordHash
                ]);

                $userId = $db->lastInsertId();

                
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'user';
                
                header('Location: ../index.php');
                exit;
            }
        } catch(PDOException $e) {
            $error = 'Ошибка сервера при регистрации';
            error_log('Register error: ' . $e->getMessage());
        }
    }
    
    // Если есть ошибка, сохраняем в сессии и возвращаем
    if ($error) {
        $_SESSION['register_error'] = $error;
        header('Location: ../index.php?error=register');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
?>