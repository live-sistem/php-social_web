<?php

session_start();
require_once __DIR__ . '/helpers.php';

$idUser = $_SESSION['user']['id'];

$update_login = $_POST['login'];
$update_name = $_POST['name'];
$update_surname = $_POST['surname'];
$update_password = $_POST['password'];


$sql = "UPDATE `users` SET `login` = ('$update_login'), `name` = ('$update_name'), `surname` = ('$update_surname'), `password` = ('$update_password')   WHERE  `users`.`id` = ('$idUser')";

if (getDB()->query($sql) === true){
    header("Location:/profile.php");
}
else{
    echo('Всё не гуд');
}