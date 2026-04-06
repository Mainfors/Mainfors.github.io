<?
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title> 
   <script defer src ="js/script.js"></script>
   <link rel="stylesheet" href="style/style.css">
</head> 

<body>
    <? if (isset($_SESSION['message'])): ?>
        <p><?=$_SESSION['message'] ?> </p>
        <? 
        unset($_SESSION['message']);
        endif; ?>
    <form class="Reg" action="php/reg.php" method="POST">
        <label for="login">Логин</label>
        <input type="text" required name="login" id="login" placeholder="Введите логин">
        <label for="password">Пароль</label>
        <input type="password" class="password" required name="password" id="password" placeholder="Введите пароль">
        <label for="repPassword">Повторите пароль</label>
        <input type="password" class = "password"  required name="repPassword" id="repPassword" placeholder="Введите пароль">
        <p id="message"></p>
        <label for="email">Email</label>
        <input type="email" required name="email" id="email" placeholder="Введите email">
        <label for="tel">Телефон:</label>
        <input type="tel" required name="tel" id="tel" placeholder="Введите телефон">
        <label for="fio">Фамилия Имя Отчество</label>
        <input type="text" required name="fio" id="fio" placeholder="Введите ФИО">
        <label for="accept">Согласен с правилами сайта</label>
        <input type="checkbox" required name="accept" id="accept">
        <input type="submit" value="Зарегестрироваться">
       <p>Есть аккаунт?</p> <a href="auth.php"> Войти</a>
    </form>                         
</body>
</html>