<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/helpers.php';
$connect = getDB(); 

// Подключение к базе данных

$conn = new mysqli($host, $user, $pass, $db);

if ($connect->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Получаем данные из запроса
$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['user_id']; // ID текущего пользователя
$friendId = $data['friend_id']; // ID пользователя, которого добавляем в друзья

// Проверяем, не отправлен ли уже запрос
$checkQuery = "SELECT * FROM friends WHERE user_id = ? AND friend_id = ?";
$stmt = $connect->prepare($checkQuery);
$stmt->bind_param('ii', $userId, $friendId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Request already sent']);
    exit;
}

// Добавляем запрос в друзья
$insertQuery = "INSERT INTO friends (user_id, friend_id, status) VALUES (?, ?, 'pending')";
$stmt = $connect->prepare($insertQuery);
$stmt->bind_param('ii', $userId, $friendId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Friend request sent']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send request']);
}

$stmt->close();
$connect->close();
?>