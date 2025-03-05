<?php
session_start();
require_once __DIR__ . '/helpers.php';


function get_list_message_user(){
    $connect = getDB();
    $idUser = $_SESSION['user']['id'];
    $sql_friend = " SELECT u.id, u.login, u.name, u.surname
                    FROM users u
                    JOIN friends f ON (u.id = f.friend_id AND f.user_id = '$idUser')
                    OR (u.id = f.user_id AND f.friend_id = '$idUser')
                    WHERE f.status = 'accepted'; 
                    ";
    $result_friend = mysqli_query($connect, $sql_friend );
    if (!$result_friend == ''){
        foreach ($result_friend as $item){
            echo('
                <a class="friend-people user-item" data-user-id="'.$item['id'].'" data-user-name="' . $item['name'] . ' ' . $item['surname'] . '">
                    <div class="friend-info-block-txt">
                        <div class="friend-photo-people">
                            <img src="assets/img/zamer.png" alt="Фото друга">
                        </div>
                        <div class="friend-info-people">
                            <div class="friend-name-people" id="name">' . $item['name'] . ' ' . $item['surname'] . '</div>
                            <div class="friend-message-people">Вы:</div>
                        </div>
                    </div>
                    <div class="friend-notification">
                        <div class="notification-count">1</div>
                        <div class="notification-time">03:00</div>
                    </div>
                </a>
            ');
        }
    }
    else{
        echo('EROR');
    }
}
?>