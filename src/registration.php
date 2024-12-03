<?php
// конект в базой данныйх

require_once __DIR__ . '/helpers.php';

// получение данный из формы

$login = $_POST['login'];
$password = $_POST['password'];

// Запись данных в базу данных

$connect = getDB();
$sql = "INSERT INTO `users` (login, password) VALUES ('$login', '$password')";
if ($connect -> query($sql) === TRUE){
    header("Location: /index.html");
}else{
    echo "Данный пользователь уже существует";
}