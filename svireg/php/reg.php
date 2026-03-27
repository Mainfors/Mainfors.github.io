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
'repPassword',
'email',
'tel',
'fio'
];

foreach($inputs as $input){
    if(!isset($_POST[$input]) || $_POST[$input]==''){
        $_SESSION['message']= "Зполните все поля!";
       header("Location:../index.php?stat=error");
            exit();    
    };
};

if($_POST['password']!== $_POST['repPassword']){
    $_SESSION['message']= "Введеные пароли не совпадают!";
        header("Location:../index.php?stat=error");
        exit();
}


$login = trim($_POST['login']);
$password = trim($_POST['password']);
$email = trim($_POST['email']);
$tel = trim($_POST['tel']);
$fio = trim($_POST['fio']);

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['message']= "Некореректный email";
        header("Location:../index.php?stat=error");
        exit();
}


require_once '../database/db.php';
// проверка существования лога и мейлов
$check =  $conn -> prepare("select exists(select 1 from sviridov where login = :login) as login_err, exists(select 1 from sviridov where email = :email) as email_err");

$check-> execute([ ':login' => $login,':email' => $email]);
$check = $check -> fetch(PDO::FETCH_ASSOC);
$errors = [];

if($check['login_err']){
    $errors[] = 'Логин занят';
};

if($check['email_err']){
    $errors[] = 'Email занят';
};

if(!empty($errors)){
    $_SESSION['message'] = implode('. ', $errors).'!';
      header("Location:../index.php?stat=error");
        exit();
    }

$newUser = $conn -> prepare(
    "insert into sviridov(login,password,email,tel,fio) values(:login,:password,:email,:tel,:fio)");

$newUser -> execute([':login' => $login,':password' => password_hash($password, PASSWORD_DEFAULT),':email' => $email, ':tel' => $tel, ':fio' => $fio]);


     $_SESSION['message']= "Успешная Регистрация";
        header("Location:../auth.php?stat=ok");
        exit();

?>