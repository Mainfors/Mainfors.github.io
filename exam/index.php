<?
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title> 
   
   <link rel="stylesheet" href="style.css">
</head> 

<body>
    <h1>Конференции.РФ</h1>
    <form class="Reg" action="php/registration.php" method="POST">
        <label for="login">Логин</label>
        <input type="text" required name="login" id="login" placeholder="Введите логин">
        <label for="password">Пароль</label>
        <input type="password" class="password" required name="password" id="password" placeholder="Введите пароль">
        <label for="email">Email</label>
        <input type="email" required name="email" id="email" placeholder="Введите email">
        <label for="tel">Телефон:</label>
        <input type="tel" required name="tel" id="tel" placeholder="Введите телефон">
        <label for="fio">Фамилия Имя Отчество</label>
        <input type="text" required name="fio" id="fio" placeholder="Введите ФИО">
        <label for="accept">Согласен с правилами сайта</label>
        <input type="checkbox" required name="accept" id="accept">
        <input type="submit" value="Зарегестрироваться">
       <p>Есть аккаунт?</p> <a href="authPage.php"> Войти</a>
    </form>                         
</body>
</html>