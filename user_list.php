<?php
$conn = new PDO ("mysql:host=localhost; dbname=sviridov","root","");
$result = $conn -> query("SELECT * from users");

foreach($result as $row){
    echo $row['id']. '*'. $row['login']. '-'. $row['password']. '<br>';
}