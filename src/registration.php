<?php
// конект в базой данныйх

require_once __DIR__ . '/helpers.php';

// получение данный из формы
if(isset($_POST['login'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $surname = $_POST['surname'];
    $output = "";

    // Запись данных в базу данных

    $connect = getDB();

    $sql = "INSERT INTO `users` (login, password, name, surname) VALUES ('$login', '$password', '$username', '$surname')";
    if ($connect -> query($sql) === TRUE){
        echo("ok");
    }else{
        echo("error");
    };

}else{
    echo '1 ошибка и ты ошибся ';
}
    

