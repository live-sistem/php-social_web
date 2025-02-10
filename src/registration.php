<?php
// конект в базой данныйх

require_once __DIR__ . '/helpers.php';

// получение данный из формы

$login = $_POST['login'];
$password = $_POST['password'];
$username = $_POST['username'];
$surname = $_POST['surname'];

$output = "";

// Запись данных в базу данных

$connect = getDB();
$sql = "INSERT INTO `users` (login, password, name, surname) VALUES ('$login', '$password', '$username', '$surname')";
if ($connect -> query($sql) === TRUE){
    header("Location: /login.html");
}else{
    echo( "EROOR");
};