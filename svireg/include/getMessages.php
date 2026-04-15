<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['userRole'] !== 'user'){
    echo '<p>Домой Волтер</p>';
    exit();
}

require_once 'database/db.php';

$messages = $conn -> prepare("select * from messages where user_id = :userId order by create_at desc");
$messages -> execute([':userId' => $_SESSION['user']['userId']]);

?>