<?php
$login = $_GET['login'];
$password = $_GET['password'];

$conn = new PDO ("mysql:host=localhost;dbname=sviridov", "root", "");

$conn -> exec ("INSERT INTO users(login, password) VALUES ('$login', '$password')");