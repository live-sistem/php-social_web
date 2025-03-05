<?php
session_start();
$idUser = $_SESSION['user']['id'];

if (!$idUser == "") {
    require_once __DIR__ . '/helpers.php';

    $outgoing_id = $idUser;
    $incoming_id=(int)$_POST['incoming_id'];
    
    $msg= htmlspecialchars($_POST['message']);
    // // Запись данных в БД
    if (!empty($msg)) {
        $sql = "INSERT INTO `messages`(`incoming_msg_id`, `outgoing_msg_id`, `msg`) 
        VALUES ('$incoming_id','$outgoing_id','$msg')";
        if($result = getDB()->query($sql)){
            echo'success';
        }
        else{
            echo'Eroor';
        }
    }
    else{
        echo('Нет Сообщений');

    }
}
else{
    echo('XASDA');

}


