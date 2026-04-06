<?php
if ($_SERVER['REQUEST_METHOD'] !=='POST'){
    http_response_code(405);
    exit();
}

session_start();



if(!isset($_SESSION['user']) || $_SESSION['user']['userRole'] !== 'user'){

     exit('DDD'); };
   
//массив данных пользователя
$inputs =[
'theme',
'message'
];

foreach($inputs as $input){
    if(!isset($_POST[$input]) || $_POST[$input]==''){
        $_SESSION['message']= "Заполните все поля!";
       header("Location:../userPage.php?stat=error");
            exit();    
    };
};




$theme = trim($_POST['theme']);
$message = trim($_POST['message']);
$userId = $_SESSION['user']['userId'];

require_once '../database/db.php';

$newMessage = $conn -> prepare(
    "insert into messages(user_id, theme, message) values(:user_id, :theme, :message)");

    $newMessage -> execute([':user_id' => $userId,':theme' =>$theme,':message' => $message]);

     $_SESSION['message']= "Сообщение отправлено";
        header("Location:../userPage.php?stat=ok");
        exit();

?>