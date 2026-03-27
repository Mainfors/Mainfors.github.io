<?
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title> 
   <link rel="stylesheet" href="style/style.css">
</head> 

<body>
    <? if (isset($_SESSION['message'])): ?>
        <p><?=$_SESSION['message'] ?> </p>
        <? 
        unset($_SESSION['message']);
        endif; ?>
    <form action="php/authpage.php" method="POST">
        <label for="login">Логин</label>
        <input type="text" required name="login" id="login" placeholder="Введите логин">
        <label for="password">Пароль</label>
        <input type="password" class="password" required name="password" id="password" placeholder="Введите пароль">
        <input type="submit" value="Войти">
        <p>Нет аккаунта?</p> <a href="index.php">Зарегестрироваться</a>
    </form>                         
</body>
</html>