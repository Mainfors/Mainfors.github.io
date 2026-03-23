<?php
require_once '../database/db.php';
$conn -> query("insert into users (login, password,
    email, tel, fio,) values('".$_POST['login']."',
    '".$_POST['login']."','".$_POST['login']."')")

?>



