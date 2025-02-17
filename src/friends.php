
<?php
session_start();

require_once __DIR__ . '/helpers.php';

if (isset($_POST['login'])) {
    $connect = getDB(); 
    $loginSearch = $_POST['login'];
    // $result = mysqli_prepare($connect, "SELECT * FROM users WHERE login LIKE ? LIMIT 10");
    $result = mysqli_prepare($connect, "SELECT `login`, `name`, `surname` FROM `users` WHERE login LIKE ? LIMIT 10");

    if ($result === false) {
        die('Ошибка подготовки запроса: ' . mysqli_error($connect));
    }

    // Привязываем параметр поиска (строка типа 's' - string)
    $searchTerm = '%' . $loginSearch . '%';
    mysqli_stmt_bind_param($result, 's', $searchTerm);

    // Выполняем запрос
    mysqli_stmt_execute($result);

    // Получаем результат
    $strm = mysqli_stmt_get_result($result);

    // Обработка результата
    $users = [];
    while ($row = mysqli_fetch_assoc($strm)) {
        // Добавляем только имя и фамилию
        $users[] = [
            'login' => $row['login'],
            'name' => $row['name'],
            'surname' => $row['surname']
        ];
    }

    // Если есть результаты, выводим их в формате JSON
    if (!empty($users)) {
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
?>
