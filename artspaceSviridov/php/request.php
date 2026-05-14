<?php
require_once '../database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/autorisation.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $requests = $_POST['requests'];
    $visit_date = $_POST['visit_date'];
    $payment = $_POST['payment'];

    $user_id = $_SESSION['user_id'];

    $dab = "INSERT INTO requests(user_id, requests, visit_date, payment)
            VALUES('$user_id','$requests','$visit_date','$payment')";

    if ($conn->query($dab)) {
        header("Location: ../profile.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    
    <div class="formik">
    
    
            <h2>Запись на мастер класс</h2>
    
            <form method="POST">
    
                <select name="requests">
                    <option>Рисование</option>
                    <option>Лепка</option>
                    <option>Дизайн</option>
                    <option>Фотография</option>
                </select>
    
                <input type="date" name="visit_date">
    
                <select name="payment">
                    <option>Наличными</option>
                    <option>Перевод по номеру телефона</option>
                </select>
    
                <button  type="submit">
                    Записаться
                </button>
    
            </form>
    
        </div>
    
    </div>
</body>
</html>