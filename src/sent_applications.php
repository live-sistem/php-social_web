
<?php
session_start();
require_once __DIR__ . '/helpers.php';


function submitted_applications(){
    $idUser = $_SESSION['user']['id'];
    // Получить всех, кому текущий пользователь отправил заявки
    $current_user_submitted_applications = "SELECT u.id, u.login, u.name, u.surname, f.created_at
                    FROM users u
                    JOIN friends f ON u.id = f.friend_id
                    WHERE f.user_id = $idUser
                    AND f.status = 'pending';";

    $result_friend = mysqli_query(getDB(), $current_user_submitted_applications );
    if (!$result_friend == ''){
        foreach ($result_friend as $item){
            echo('
                <div class="request-item" data-user-id=" ' .$item['id']. ' ">
                    <div class="d-flex">
                        <img class="request-item-photo" src="assets/img/zamer.png" alt="">
                        <div class="request-item-friend">
                            <strong id="request-item-login"> ' . $item['login'].' </strong>
                            <strong id="request-item-name"> ' . $item['name'] . ' ' . $item['surname'] . ' </strong>
                            <small id="request-item-time"> ' . $item['created_at'] . ' </small>
                        </div>
                    </div>
                    <img class="request_cancel_img" src="assets/img/cancel-request.png" alt="">
                </div>
            ');
        }
    }
    else{
        echo('EROR');
    }
}

function receive_applications(){
    $idUser = $_SESSION['user']['id'];
    // Получить все, заявки текущего пользователя 
    $sql_friend ="  SELECT u.id, u.login, u.name, u.surname, f.created_at
                    FROM users u
                    JOIN friends f ON u.id = f.user_id
                    WHERE f.friend_id = '$idUser'
                    AND f.status = 'pending';";

    $result_friend = mysqli_query(getDB(), $sql_friend );
    if (!$result_friend == ''){
        foreach ($result_friend as $item){
            echo('
                <div class="request-item" id="iduser" data-user-id=" ' . $item['id'] . ' ">
                    <div class="d-flex">
                        <img class="request-item-photo" src="assets/img/zamer.png" alt="">
                        <div class="request-item-friend">
                            <strong id="request-for-you-item-login"> ' . $item['login'] . ' </strong>
                            <strong id="request-for-you-item-name"> ' . $item['name'] . ' ' . $item['surname'] . '</strong>
                            <small id="request-for-you-item-time"> ' . $item['created_at'] . ' </small>
                        </div>
                    </div>
                    <div>
                        <img class="request_cancel_img" id="check_yes_application_box" src="assets/img/check_mark.png" alt="">
                        <img class="request_cancel_img" id="check_no_application_box" src="assets/img/cancel-request.png" alt="">
                    </div>
                </div>
            ');
        }
    }
    else{
        echo('EROR');
    }
};

?>
