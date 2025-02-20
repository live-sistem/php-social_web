<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/helpers.php';
$connect = getDB(); 

// Подключение к базе данных

// вот таблица 'friends'
// user_id
// friend_id
// status - 'pending', 'accepted', 'rejected' - ожидает", "принято", "отклонено
// created_at

$sql_messageы = "";
if ($connect->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Чтение и декодирование JSON из тела запроса, php по умолчанию не может парсить JSON из $_POST
$data = json_decode(file_get_contents('php://input'), true);

// Проверка на наличие данных
if (isset($data['login']) && isset($data['nameUser'])) {
    $friendId = $data['User_id'];

    $userId = $_SESSION['user']['id']; // ID текущего пользователя

    $friendLogin = $data['login']; // Логин пользователя, которого добавляем в друзья

    $sql = "SELECT * FROM `friends` WHERE (`user_id` = $userId AND `friend_id` = $friendId) OR (`user_id` = $friendId AND `friend_id` = $userId)";

    $result_messages = mysqli_query($connect, $sql);
    if ($result_messages) {
        if ($result_messages -> num_rows > 0){
            echo 'запрос был уже выполнен'; 
            while ($row = mysqli_fetch_assoc($result_messages)) {
                echo "Найдена запись: " . print_r($row, true);
            }
        }
        else{
            $status_friend= 'pending';
            $result_messages = mysqli_query($connect, 
            "INSERT INTO `friends` (user_id, friend_id, status) VALUES ('$userId', '$friendId', '$status_friend')");
            echo 'запрос отправлен';

        }
    } else {
        echo "Ошибка запроса аааааааааа:" . $mysqli->error;
        }   
    
        
    // echo json_encode([
    //     'status' => 'success',
    //     'message' => "User ID: $userId is adding Friend with login: $friendLogin",
    //     'sql' => "$result_messages"
    // ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid input data'
    ]);
}
?>
