<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/helpers.php';

// Подключение к базе данных
// вот таблица 'friends'
// user_id
// friend_id
// status - 'pending', 'accepted', 'rejected' - ожидает", "принято", "отклонено
// created_at

// примерный JSON 
// {"User_id":1,"login":"logan2413","nameUser":"Павел Носов"}


// Чтение и декодирование JSON из тела запроса, php по умолчанию не может парсить JSON из $_POST
$data = json_decode(file_get_contents('php://input'), true);

// Проверка на наличие данных
if (isset($data['User_id'])) {
    $connect = getDB(); 
    $friendId = $data['User_id'];

    $userId = $_SESSION['user']['id']; // ID текущего пользователя

    $friendLogin = $data['login']; // Логин пользователя, которого добавляем в друзья
    $friendName = $data['nameUser']; // Имя пользователя, которого добавляем в друзья

    $sql = "SELECT * FROM `friends` 
    WHERE (`user_id` = $userId AND `friend_id` = $friendId) 
    OR (`user_id` = $friendId AND `friend_id` = $userId)";
    
    $sql_insert = "INSERT INTO `friends` (user_id, friend_id, status) VALUES ('$userId', '$friendId', 'pending')";

    $result_messages = mysqli_query($connect, $sql);

    echo("' Это id друга ' $friendId, 
            ' Логин пользователя, которого добавляем в друзья ' $friendLogin,
            ' Имя пользователя, которого добавляем в друзья ' $friendName,
            ' Это id нынешнего пользователя ' $userId, 
            ' Это ответ из Базы данных ',"); 

    print_r($result_messages);

    if ($result_messages -> num_rows > 0){
        while ($row = mysqli_fetch_assoc($result_messages)) {
            echo "Найдена запись: " . print_r($row, true);
            
        }
    }else{
        echo('Вот умора, она работает.');

        $result_messages = mysqli_query($connect, $sql_insert);
    }
   
    

    // if ($result_messages) {
    //     if ($result_messages -> num_rows > 0){
    //         echo 'запрос был уже выполнен'; 
    //         while ($row = mysqli_fetch_assoc($result_messages)) {
    //             echo "Найдена запись: " . print_r($row, true);
    //         }
    //     }
    //     else{
    //         $status_friend = 'pending';
            
    //         $result_messages = mysqli_query($connect, 
    //         "INSERT INTO `friends` (user_id, friend_id, status) 
    //         VALUES ('$userId', '$friendId', $status_friend)");

    //         
    //     }
    // } else {
    //     echo "Ошибка запроса :" . $mysqli->error;
    //     }   
    
        
    // echo json_encode([
    //     'status' => 'success',
    //     'message' => "User ID: $userId is adding Friend with login: $friendLogin",
    //     'sql' => "$result_messages"
    // ]);
    echo 'Тут конец add_friend.php';
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid input data'
    ]);
}
?>
