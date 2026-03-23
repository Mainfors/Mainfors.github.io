<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
   <script defer src ="js/script.js"></script>
</head> 
<body>
    <form action="php/reg.php" method="POST">
        <label for="login">Логин</label>
        <input type="text" required name="login" id="login" placeholder="Введите логин">
        <label for="password">Пароль</label>
        <input type="password" class="password" required name="password" id="password" placeholder="Введите пароль">
        <label for="repPassword">Повторите пароль</label>
        <input type="password" class = "password" required name="repPassword" id="repPassword" placeholder="Введите пароль">
        <p id="message"></p>
        <label for="email">Email</label>
        <input type="email" required name="email" id="email" placeholder="Введите email">
        <label for="tel">Телефон:</labe     l>
        <input type="tel" required name="tel" id="tel" placeholder="Введите телефон">
        <label for="fio">Фамилия Имя Отчество</label>
        <input type="text" required name="fio" id="fio" placeholder="Введите ФИО">
        <label for="accept">Согласен с правилами сайта</label>
        <input type="checkbox" required name="accept" id="accept">
        <input type="submit" value="Зарегестрироваться">
    </form>                         
</body>
</html>