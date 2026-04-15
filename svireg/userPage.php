<? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <? if(!isset($_SESSION['user']) || $_SESSION['user']['userRole'] !== 'user'): ?>
        <p>Доступ только для авторизованных пользователей <a href="auth.php">ВОЙТИ</a></p>
    </body>
    </html>
    <? exit(); 
    endif;
   ?>

   <? if (isset($_SESSION['message'])): ?>
        <p><?=$_SESSION['message'] ?> </p>
        <? 
        unset($_SESSION['message']);
        endif; ?>
    
   <form action="php/sendMessage.php" method = 'Post'>
    <label for="theme">Тема:</label>
    <input type="text" id ="theme" name ="theme">
    <label for="message">Сообщение:</label>
    <textarea name="message" id="message"></textarea>
    <input type="submit" value = "Отправить">
</form>
        <? include 'include/getMessages.php';
        foreach($messages as $message):?>
        <div class="message">
            <p> Тема: <?= $message['theme'] ?></p>
            <p> Сообщение: <?= $message['message'] ?></p>
            <p> Дата: <?= $message['create_at'] ?></p>
        </div>
        <? endforeach ?>
    <a href="php/logOut.php">Выйти из аккаунта</a>
</body>
</html>