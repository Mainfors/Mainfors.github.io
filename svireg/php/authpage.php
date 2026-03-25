<?php
if ($_SERVER['REQUEST_METHOD'] !=='POST'){
    http_response_code(405);
    exit();
}

session_start();
//массив данных пользователя
$inputs =[
'login',
'password',
];

foreach($inputs as $input){
    if(!isset($_POST[$input]) || $_POST[$input]==''){
        $_SESSION['message']= "Заполните все поля!";
       header("Location:../auth.php?stat=error");
            exit();    
    };
};



$login = trim($_POST['login']);
$password = $_POST['password'];


require_once '../database/db.php';

$CheckUser = $conn -> prepare(
    "select * from sviridov where login = :login or email = :email");

$CheckUser -> execute([':login' => $login, ':email' => $login]);


$CheckUser = $CheckUser -> fetch(PDO::FETCH_ASSOC);

if(!$CheckUser || !password_verify($password, $CheckUser['password'])){
     $_SESSION['message']= "Неверный логин или пароль";
       header("Location:../auth.php?stat=error");
            exit();
}

     $_SESSION['message']= "Успешная Регистрация";
        header("Location:../index.php?stat=ok");
        exit();

?>