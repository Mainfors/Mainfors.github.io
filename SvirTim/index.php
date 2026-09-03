<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dagestanovo.net - Паспорт проекта</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="bolshoyboxik">
        <header>
            <h1> Dagestanovo.net</h1>
            <div class="auth-buttons">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="user-name"><?php echo $_SESSION['user_name']; ?></span>
                    <a href="logout.php" class="btn btn-danger">Выйти</a>
                <?php else: ?>
                    <a href="registration.php" class="btn btn-primary">Регистрация</a>
                    <a href="login.php" class="btn btn-outline">Вход</a>
                <?php endif; ?>
            </div>
        </header>

        <nav class="main-nav">
            <a href="index.php" class="active">Паспорт проекта</a>
            <a href="bookings.php"> Бронирования</a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin.php"> Админ-панель</a>
            <?php endif; ?>
        </nav>

        <section class="project-passport">
            <h2> Паспорт проекта</h2>
            <table class="passport-table">
                <thead>
                    <tr>
                        <th>Параметр</th>
                        <th>Описание</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><h3>Название</h3></td>
                        <td>Dagestanovo.net - сервис бронирования кабинетов в Дагестане</td>
                    </tr>
                    <tr>
                        <td><h3>Описание</h3></td>
                        <td>Веб-платформа для бронирования переговорных и рабочих кабинетов в бизнес-центрах Дагестана</td>
                    </tr>
                    <tr>
                        <td><h3>Предметная область</h3></td>
                        <td>Управление ресурсами (коворкинг, бизнес-центры, офисные помещения)</td>
                    </tr>
                    <tr>
                        <td><h3>Проблема</h3></td>
                        <td>Отсутствие единой системы бронирования кабинетов в Дагестане, неэффективное использование помещений</td>
                    </tr>
                    <tr>
                        <td><h3>Цель</h3></td>
                        <td>Создать удобный онлайн-сервис для бронирования кабинетов с системой авторизации и ролевой моделью</td>
                    </tr>
                    <tr>
                        <td><h3>Роли</h3></td>
                        <td>
                            <span>Администратор</span> - управление заявками, редактирование статусов<br>
                            <span>Пользователь</span> - создание и просмотр своих заявок<br>
                        </td>
                    </tr>
                    <tr>
                        <td><h3>Данные</h3></td>
                        <td>Пользователи, кабинеты, заявки на бронирование, статусы заявок</td>
                    </tr>
                    <tr>
                        <td><h3>Функции</h3></td>
                        <td>
                            <ul>
                                <li>Регистрация и авторизация пользователей</li>
                                <li>Создание заявок на бронирование</li>
                                <li>Управление заявками (администратор)</li>
                                <li>Изменение статусов заявок</li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                    <td><h3>Нефункциональные</h3></td>
                    <td>
                            <ul>
                                <li>Проверка доступности кабинетов</li>
                                <li>Удобный дизайн</li>
                                 <li>Просмотр кабинетов</li>
                            </ul>
                    </td>
                </tr>
                    <tr>
                        <td><h3>Бизнес-правила</h3></td>
                        <td> Можно забронировать только свободный кабинет<br>
                        Посещение кабинета доступно только после подтверждения брони администратором сайта <br>
                        Чтобы забронировать кабинет нужно: <br> 1.Авторизоваться <br> 2.Выбрать свободный кабинет из списка <br> 3.Установить дату и время желаемого посещения
                        
                    </td>
                        
                    </tr>
                </tbody>
            </table>
            </section>

        <section class="quick-actions">
            <h3> Бронь</h3>
            <div class="action-cards">
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <div class="card">
                        <h4> Для бронирования</h4>
                        <p>Войдите или зарегистрируйтесь, чтобы создавать заявки</p>
                        <a href="registration.php" class="btn">Регистрация</a>
                        <a href="login.php" class="btn">Вход</a>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <h4> Забронировать</h4>
                        <p>Перейдите в раздел бронирований</p>
                        <a href="bookings.php" class="btn ">Перейти к бронированию</a>
                    </div>
                    <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>