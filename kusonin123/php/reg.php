<?php
if ($_SERVER['REQUEST_METHOD'] !=='POST'){
    http_response_code(405);
    exit();
}

session_start();

$inputs =[
'login',
'password',
'repPassword',
'email',
'tel',
'fio'
];

foreach($inputs as $input){
    if(!isset($_POST[$input]) || $_POST[$input]==''){
        $_SESSION['message']= "Зполните все поля!";
        header("Location:../index.php?stat=error");
    };
};


require_once '../database/db.php';
$conn -> query("insert into users (login, password, email, tel, fio) values('".$_POST['login']."','".$_POST['password']."','".$_POST['email']."','".$_POST['tel']."','".$_POST['fio']."')");
