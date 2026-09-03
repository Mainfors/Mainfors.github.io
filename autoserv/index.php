<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="slider-box">
        <div class="slides" id="slider">
            <div class="slide"><img src="media/auto1.webp"></div>
            <div class="slide"><img src="media/auto2.webp"></div>
            <div class="slide"><img src="media/auto3.webp"></div>
            <div class="slide"><img src="media/auto4.webp"></div>
        </div>
    </div>

    <h2>Регистрация</h2>
    
    <?php if(isset($_SESSION['message'])): ?>
        <p>
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </p>
    <?php endif; ?>

    <form action="php/reg.php" method="POST">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="text" name="fio" placeholder="ФИО" required>
        <input type="tel" name="tel" placeholder="8(909)900-99-00" required>
        <input type="email" name="email" placeholder="keepchik@mail.ru" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
    
    <div class="link-group">
        <a href="authPage.php">Уже есть аккаунт? Войти</a>
    </div>
</div>

<script>
    let count = 0;
    const slider = document.getElementById('slider');
    
    setInterval(() => {
        count++;
        if(count > 3) count = 0;
            slider.style.transform = `translateX(-${count * 25}%)`;
    }, 2000);
</script>

</body>
</html>