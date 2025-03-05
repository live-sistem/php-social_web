<?php
session_start();
require_once __DIR__ . '/helpers.php';

function get_users(){
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
                <div class="friend">
                    <div class="friend-block-photo-and-info">
                        <div class="friend-photo">
                            <img src="assets/img/zamer.png" alt="Фото друга">
                        </div>
                        <div class="friend-info">
                            <div class="friend-name">'
                                . $item['name']. ' '. $item['surname'].'
                            </div>
                            <a href="" class="friend_chat_to_link">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 2H5C3.897 2 3 2.894 3 3.992V16.008C3 17.106 3.897 18 5 18V21L11 18H21C22.103 18 23 17.106 23 16.008V3.992C22.9984 3.46279 22.7869 2.95583 22.412 2.58237C22.037 2.20891 21.5292 1.99947 21 2Z" fill="#0B5ED7"/>
                                    <path d="M9.5 10C9.5 10.8284 8.82843 11.5 8 11.5C7.17157 11.5 6.5 10.8284 6.5 10C6.5 9.17157 7.17157 8.5 8 8.5C8.82843 8.5 9.5 9.17157 9.5 10Z" fill="#D9D9D9"/>
                                    <path d="M14.5 10C14.5 10.8285 13.8284 11.5 13 11.5C12.1716 11.5 11.5 10.8285 11.5 10C11.5 9.1716 12.1716 8.50003 13 8.50003C13.8284 8.50003 14.5 9.1716 14.5 10Z" fill="#D9D9D9"/>
                                    <path d="M19.5 10C19.5 10.8284 18.8284 11.5 18 11.5C17.1716 11.5 16.5 10.8284 16.5 10C16.5 9.17157 17.1716 8.5 18 8.5C18.8284 8.5 19.5 9.17157 19.5 10Z" fill="#D9D9D9"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="delete_friend">
                        <div class="delete_friend_icon"><img src="assets/img/icon_delete.png" alt=""></div>
                    </div>
                </div>
            ');
        }
    }
    else{
        echo('EROR');
    }
}
?>