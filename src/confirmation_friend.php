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

// Чтение и декодирование JSON из тела запроса, php по умолчанию не может парсить JSON из $_POST
$data = json_decode(file_get_contents('php://input'), true);

// Проверка на наличие данных
if (isset($data['user_id_friend'])) {
    $connect = getDB(); 
    // тот кто отправил запрос
    $friendId = $data['user_id_friend'];

    $userId = $_SESSION['user']['id']; // ID текущего пользователя

    $sql = "SELECT * FROM `friends` WHERE (`user_id` = $userId AND `friend_id` = $friendId) OR (`user_id` = $friendId AND `friend_id` = $userId)";
    
    $sql_friends_add = "UPDATE `friends`
                        SET `status` = 'accepted'
                        WHERE `user_id` = $friendId AND `friend_id` = $userId;";

    $result_messages = mysqli_query($connect, $sql);

    if ($result_messages) {
        if ($result_messages -> num_rows > 0){
            echo '1 условие '; 
            $result_sql = mysqli_query($connect, $sql_friends_add);

            if ($result_messages -> num_rows > 0){
                echo 'запрос выполнен, теперь вы друзья ';
            }
            else{
                echo 'что то пошло не так ';
            }
        }
        else{
            echo '2 условие'; 
            echo 'всё грусно';

        }
    } else {
        echo "Ошибка запроса :" . $mysqli->error;
        }   
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid input data'
    ]);
}
?>
