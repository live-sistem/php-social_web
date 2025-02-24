<?php
session_start();
require_once __DIR__ . '/helpers.php';
$connect = getDB(); 

if (!isset($_SESSION['user']['id'])) {
    die('Ошибка: пользователь не найден в сессии');
}
else{
    if (isset($_POST['login'])) {
    
        $loginSearch = $_POST['login'];
        $idUser = $_SESSION['user']['id'];
        $result = mysqli_prepare($connect, "SELECT `id`, `login`, `name`, `surname` FROM `users` WHERE login LIKE ? AND id != ? LIMIT 6");
        
        if ($result === false) {
            die('Ошибка подготовки запроса: ' . mysqli_error($connect));
        }
        // Привязываем параметр поиска (строка типа 's' - string)
        $searchTerm = '%' . $loginSearch . '%';
    
        mysqli_stmt_bind_param($result, 'si', $searchTerm, $idUser);
    
        // Выполняем запрос
        mysqli_stmt_execute($result);
    
        // Получаем результат
        $strm = mysqli_stmt_get_result($result);
    
        // Обработка результата
        $users = [];
        while ($row = mysqli_fetch_assoc($strm)) {
    
            // Добавляем в массив данные 
            $users[] = [
                'id' => $row['id'],
                'login' => $row['login'],
                'name' => $row['name'],
                'surname' => $row['surname']
            ];
        }
    
        // Если есть результаты, выводим их в формате JSON
        if (!empty($users)){
            header('Content-Type: application/json; charset=utf-8');
            
            echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
    
            // Если нет результатов, выводим сообщение об ошибке
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Пользователи не найдены'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    
        mysqli_stmt_close($result);
        mysqli_close($connect);
    } else {
        
        // Если форма не отправлена или логин не задан
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Ошибка: запрос не содержит логина для поиска'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}


?>
