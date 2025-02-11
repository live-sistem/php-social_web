<?php
session_start();

require_once __DIR__ . '/helpers.php';

// получение данный из формы
if(isset($_POST['login'])){
    $login = $_POST['login'];
    $password = $_POST['password'];
    // Запись данных в базу данных
    $connect = getDB();
    $sql = "SELECT * FROM `users` WHERE `login` = ('$login') AND `password` = ('$password')";

    $result = $connect->query($sql);

    if ($result -> num_rows > 0){
        while($row = $result->fetch_assoc()){
            $_SESSION['user']['id'] = $row['id'];
            echo json_encode(['success' => true]);
        }
    }else{
        echo json_encode(['success' => false, 'message' => 'Заполните все поля!']);
    }

}else{
    echo '1 ошибка и ты ошибся это была страница login ';
}
