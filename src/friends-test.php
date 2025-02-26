
<?php
session_start();

require_once __DIR__ . '/helpers.php';
$idUser = $_SESSION['user']['id'];

if (isset($_POST['login'])) {
    $connect = getDB(); 
    $loginSearch = $_POST['login'];
    // $result = mysqli_prepare($connect, "SELECT * FROM users WHERE login LIKE ? LIMIT 6");
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
    $users = "";
    // добавить кнопку 
    // <!-- <svg width="35px" height="35px" viewBox="-4.56 -4.56 33.12 33.12" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"><path transform="translate(-4.56, -4.56), scale(2.07)" fill="#0b5ed7" d="M9.166.33a2.25 2.25 0 00-2.332 0l-5.25 3.182A2.25 2.25 0 00.5 5.436v5.128a2.25 2.25 0 001.084 1.924l5.25 3.182a2.25 2.25 0 002.332 0l5.25-3.182a2.25 2.25 0 001.084-1.924V5.436a2.25 2.25 0 00-1.084-1.924L9.166.33z" strokewidth="0"></path></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 14L9 19L20 8M6 8.88889L9.07692 12L16 5" stroke="#ffffff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg> --> 
    while ($row = mysqli_fetch_assoc($strm)){
        // Добавляем в массив данные search-class-friends
        $users .= 
        '<div id="search-friends-id" class="search-class-friends">
            <div class="search-friends">
                <div>
                    <div class="search-item-id" hidden>'.$row['id'].'</div>
                    <div class="search-item-login" id="search-item-login-id">
                        '.$row['login'].'
                    </div>
                    <div class="search-item-name" id="search-item-name-id">     
                        '.$row['name'].'
                        '.$row['surname'].'
                    </div>
                </div>
                <div class="search-item-button">
                    <button type="submit">
                        Отправить запрос
                    </button>
                </div>
            </div>
        </div>
        ';
    }
    
    // // Если есть результаты, выводим их в формате JSON
    // if (!empty($users)){
    //     header('Content-Type: application/json; charset=utf-8');
    //     echo json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // } else {
    //     // Если нет результатов, выводим сообщение об ошибке
    //     header('Content-Type: application/json; charset=utf-8');
    //     echo json_encode(['error' => 'Пользователи не найдены'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    // }
    echo $users;
    // mysqli_stmt_close($result);
    // mysqli_close($connect);
} else {
    // Если форма не отправлена или логин не задан
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Ошибка: запрос не содержит логина для поиска'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
