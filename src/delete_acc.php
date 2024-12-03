<?php 
function delete_account(){   
    require_once __DIR__ . '/helpers.php';

    $idUser = $_SESSION['user']['id'];
    $sql_users = "DELETE FROM `users` WHERE  `id` = ('$idUser')";
    if (getDB()->query($sql_users) === true){
        header("Location:/");
    }
    else{
        echo('Что-то пошло не так.');
    }
}