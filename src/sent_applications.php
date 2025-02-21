
<?php
session_start();

require_once __DIR__ . '/helpers.php';

$connect = getDB(); 

function receive_applications(){
    $idUser = $_SESSION['user']['id'];

    // Получить всех, кому текущий пользователь отправил заявки

    // $current_user_submitted_applications = " SELECT u.id, u.login, u.name, u.surname, f.created_at
    //                 FROM users u
    //                 JOIN friends f ON u.id = f.friend_id
    //                 WHERE f.user_id = 3
    //                 AND f.status = 'pending';";
    // // Получить всех, кому текущий пользователь получил заявки

    $sql_friend ="  SELECT u.id, u.login, u.name, u.surname, f.created_at
                    FROM users u
                    JOIN friends f ON u.id = f.user_id
                    WHERE f.friend_id = '$idUser'
                    AND f.status = 'pending';";


    $result_friend = mysqli_query(getDB(), $sql_friend );
    if (!$result_friend == ''){
        foreach ($result_friend as $item){
            echo('
                <div class="request-item" data-user-id="'.$item['id'].'">
                    <div class="d-flex">
                        <img class="request-item-photo" src="assets/img/zamer.png" alt="">
                        <div class="request-item-friend">
                            <strong>'. $item['login'].' </strong>
                            <strong>'. $item['name'].' '.$item['surname'].'</strong>
                            <small>'.$item['created_at'].'</small>
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
};
function submitted_applications(){
    $idUser = $_SESSION['user']['id'];

    // Получить всех, кому текущий пользователь отправил заявки

    $current_user_submitted_applications = " SELECT u.id, u.login, u.name, u.surname, f.created_at
                    FROM users u
                    JOIN friends f ON u.id = f.friend_id
                    WHERE f.user_id = $idUser
                    AND f.status = 'pending';";


    $result_friend = mysqli_query(getDB(), $current_user_submitted_applications );
    if (!$result_friend == ''){
        foreach ($result_friend as $item){
            echo('
                <div class="request-item" data-user-id="'.$item['id'].'">
                    <div class="d-flex">
                        <img class="request-item-photo" src="assets/img/zamer.png" alt="">
                        <div class="request-item-friend">
                            <strong>'. $item['login'].' </strong>
                            <strong>'. $item['name'].' '.$item['surname'].'</strong>
                            <small>'.$item['created_at'].'</small>
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



// if (isset($_POST['id'])) {
    
//     $loginSearch = $_POST['login'];

//     // метод для удаления запроса в друзья 
//     // $result = mysqli_prepare($connect, 
//     //     "DELETE FROM friends
//     //     WHERE user_id = ?
//     //     AND friend_id = ?
//     //     AND status = ?
//     //     AND created_at = ?;
//     //     ");

//     if ($result === false) {
//         die('Ошибка подготовки запроса: ' . mysqli_error($connect));
//     }
//     // Привязываем параметр поиска (строка типа 's' - string)
//     $searchTerm = '%' . $loginSearch . '%';
//     mysqli_stmt_bind_param($result, 's', $searchTerm);
//     // Выполняем запрос
//     mysqli_stmt_execute($result);
//     // Получаем результат
//     $strm = mysqli_stmt_get_result($result);
//     // Обработка результата
//     $users = "";
//     // добавить кнопку 
//     // <!-- <svg width="35px" height="35px" viewBox="-4.56 -4.56 33.12 33.12" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"><path transform="translate(-4.56, -4.56), scale(2.07)" fill="#0b5ed7" d="M9.166.33a2.25 2.25 0 00-2.332 0l-5.25 3.182A2.25 2.25 0 00.5 5.436v5.128a2.25 2.25 0 001.084 1.924l5.25 3.182a2.25 2.25 0 002.332 0l5.25-3.182a2.25 2.25 0 001.084-1.924V5.436a2.25 2.25 0 00-1.084-1.924L9.166.33z" strokewidth="0"></path></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 14L9 19L20 8M6 8.88889L9.07692 12L16 5" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg> --> 
//     while ($row = mysqli_fetch_assoc($strm)){
//         // Добавляем в массив данные search-class-friends
//         $users .= 
//         '<div id="search-friends-id" class="search-class-friends">
//             <div class="search-friends">
//                 <div>
//                     <div class="search-item-id" hidden>'.$row['id'].'</div>
//                     <div class="search-item-login" id="search-item-login-id">
//                         '.$row['login'].'
//                     </div>
//                     <div class="search-item-name" id="search-item-name-id">     
//                         '.$row['name'].'
//                         '.$row['surname'].'
//                     </div>
//                 </div>
//                 <div class="search-item-button">
//                     <button type="submit">
//                     Отправить запрос
//                     </button>
//                 </div>
//             </div>
//         </div>
//         ';
//     }
    
//     // // Если есть результаты, выводим их в формате JSON
//     // if (!empty($users)){
//     //     header('Content-Type: application/json; charset=utf-8');
//     //     echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//     // } else {
//     //     // Если нет результатов, выводим сообщение об ошибке
//     //     header('Content-Type: application/json; charset=utf-8');
//     //     echo json_encode(['error' => 'Пользователи не найдены'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//     // }
//     echo $users;
//     // mysqli_stmt_close($result);
//     // mysqli_close($connect);
// } else {
//     // Если форма не отправлена или логин не задан
//     header('Content-Type: application/json; charset=utf-8');
//     echo json_encode(['error' => 'Ошибка: запрос не содержит логина для поиска'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
// }
?>
