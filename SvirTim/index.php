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
    <div class="container">
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
                        <td><strong>Название</strong></td>
                        <td>Dagestanovo.net - сервис бронирования кабинетов в Дагестане</td>
                    </tr>
                    <tr>
                        <td><strong>Описание</strong></td>
                        <td>Веб-платформа для бронирования переговорных и рабочих кабинетов в бизнес-центрах Дагестана</td>
                    </tr>
                    <tr>
                        <td><strong>Предметная область</strong></td>
                        <td>Управление ресурсами (коворкинг, бизнес-центры, офисные помещения)</td>
                    </tr>
                    <tr>
                        <td><strong>Проблема</strong></td>
                        <td>Отсутствие единой системы бронирования кабинетов в Дагестане, неэффективное использование помещений</td>
                    </tr>
                    <tr>
                        <td><strong>Цель</strong></td>
                        <td>Создать удобный онлайн-сервис для бронирования кабинетов с системой авторизации и ролевой моделью</td>
                    </tr>
                    <tr>
                        <td><strong>Роли</strong></td>
                        <td>
                            <span class="role-badge admin">Администратор</span> - управление заявками, редактирование статусов<br>
                            <span class="role-badge user">Пользователь</span> - создание и просмотр своих заявок<br>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Данные</strong></td>
                        <td>Пользователи, кабинеты, заявки на бронирование, статусы заявок</td>
                    </tr>
                    <tr>
                        <td><strong>Функции</strong></td>
                        <td>
                            <ul>
                                <li>Регистрация и авторизация пользователей</li>
                                <li>Просмотр доступных кабинетов</li>
                                <li>Создание заявок на бронирование</li>
                                <li>Управление заявками (администратор)</li>
                                <li>Изменение статусов заявок</li>
                                <li>Проверка доступности кабинетов</li>
                            </ul>
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
                        <a href="registration.php" class="btn btn-primary">Регистрация</a>
                        <a href="login.php" class="btn btn-outline">Вход</a>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <h4> Забронировать</h4>
                        <p>Перейдите в раздел бронирований</p>
                        <a href="bookings.php" class="btn btn-primary">Перейти к бронированию</a>
                    </div>
                    <?php endif; ?>
            </div>
        </section>

        <footer>
            <p>© 2026 Dagestanovo.net - Бронирование кабинетов в Дагестане</p>
        </footer>
    </div>
</body>
</html>