<?php
session_start();

require_once __DIR__ . '/helpers.php';

// получение данный из формы

$login = $_POST['login'];
$password = $_POST['password'];

// Запись данных в базу данных

$connect = getDB();

$sql = "SELECT * FROM `users` WHERE `login` = ('$login') AND `password` = ('$password')";

$result = $connect->query($sql);

if ($result -> num_rows > 0){
    while($row = $result->fetch_assoc()){
        
        $_SESSION['user']['id'] = $row['id'];
        
        header("Location: /profile.php");
    }
}else{
    echo "Вы ввели не коректные данные";
}


