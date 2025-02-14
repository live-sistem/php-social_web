<?php
session_start();
require_once __DIR__ . '/src/helpers.php';
require __DIR__ . '/src/delete_acc.php';

$connect = getDB();

$idUser = $_SESSION['user']['id'];
if ($idUser == ''){
    header("Location: /");
}
$sql_users = "SELECT * FROM `users` WHERE `id` = ('$idUser')";

$result_user = mysqli_query($connect, $sql_users );

$result_user = mysqli_fetch_all($result_user);

foreach ($result_user as $item){
    $login =  $item[1];
    $name = $item[2];
    $surname = $item[3];
    $password = $item[4];
    $unique_id = $item[5];
}

// Вызывается функция получение всех users в вкладке сообщения. 
function get_list_message_user(){
    $idUser = $_SESSION['user']['id'];

    $sql_friend = "SELECT * FROM `users` WHERE NOT `id` = ('$idUser')";

    $result_friend = mysqli_query(getDB(), $sql_friend );
    
    if (!$result_friend == ''){

        foreach ($result_friend as $item){
            echo('
                <a class="friend-people user-item" data-user-id="'.$item['id'].'" data-user-name="' . $item['name'] . ' ' . $item['surname'] . '">
                    <div class="friend-info-block-txt">
                        <div class="friend-photo-people">
                            <img src="assets/img/zamer.png" alt="Фото друга">
                        </div>
                        <div class="friend-info-people">
                            <div class="friend-name-people" id="name">' . $item['name'] . ' ' . $item['surname'] . '</div>
                            <div class="friend-message-people">?</div>
                        </div>
                    </div>
                    <div class="friend-notification">
                        <div class="notification-count">???</div>
                        <div class="notification-time">??:??</div>
                    </div>
                </a>
            ');
        }

    }
    else{
        echo('EROR');
    }
    // href="profile.php?user_id='. $item['id'] .'"
}

// вызывается функция получение всех. 
function get_users(){
    $idUser = $_SESSION['user']['id'];
                  
    $sql_friend = "SELECT * FROM `users` WHERE NOT `id` = ('$idUser')";

    $result_friend = mysqli_query(getDB(), $sql_friend );
    
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
if(array_key_exists('editProfile',$_POST)){
    if ($_POST)
    delete_account();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <!-- Logout --> 
                <button class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                    <svg class="d-flex justify-content-center" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="30,30,200,200">
                        <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(8.53333,8.53333)"><path d="M3,7c-0.36064,-0.0051 -0.69608,0.18438 -0.87789,0.49587c-0.18181,0.3115 -0.18181,0.69676 0,1.00825c0.18181,0.3115 0.51725,0.50097 0.87789,0.49587h24c0.36064,0.0051 0.69608,-0.18438 0.87789,-0.49587c0.18181,-0.3115 0.18181,-0.69676 0,-1.00825c-0.18181,-0.3115 -0.51725,-0.50097 -0.87789,-0.49587zM3,14c-0.36064,-0.0051 -0.69608,0.18438 -0.87789,0.49587c-0.18181,0.3115 -0.18181,0.69676 0,1.00825c0.18181,0.3115 0.51725,0.50097 0.87789,0.49587h24c0.36064,0.0051 0.69608,-0.18438 0.87789,-0.49587c0.18181,-0.3115 0.18181,-0.69676 0,-1.00825c-0.18181,-0.3115 -0.51725,-0.50097 -0.87789,-0.49587zM3,21c-0.36064,-0.0051 -0.69608,0.18438 -0.87789,0.49587c-0.18181,0.3115 -0.18181,0.69676 0,1.00825c0.18181,0.3115 0.51725,0.50097 0.87789,0.49587h24c0.36064,0.0051 0.69608,-0.18438 0.87789,-0.49587c0.18181,-0.3115 0.18181,-0.69676 0,-1.00825c-0.18181,-0.3115 -0.51725,-0.50097 -0.87789,-0.49587z"></path></g></g>
                    </svg>
                </button>
                <!-- Боковая панель --> 
                <div class="offcanvas offcanvas-start " tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Offcanvas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div>
                        Some text as placeholder. In real life you can have the elements you have chosen. Like, text, images, lists, etc.
                        </div>
                        <div class="dropdown mt-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Dropdown button
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a  class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                        </div>
                    </div>
                </div>
                <form class="d-flex">
                    <a href="src/logout.php"><button type="button" class="btn btn-danger">Выйти</button></a>
                </form>
            </div>
        </nav>
    </header>
    <main>
        <div class="container d-flex justify-content-center">
            <div class="d-flex">
                <!-- Баннер профиля  --> 
                <div class="m-3 pesone_profile">
                    <div class="card" style="width: 18rem;">
                        <img src="/assets/img/profile.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="list-group">
                                <button type="button" class="btn_colec fw-bold list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                    Друзья
                                    <span class="badge text-bg-primary rounded-pill">+</span>
                                </button>
                                <button type="button" class="btn_colec fw-bold list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                    Заявки
                                    <span class="badge text-bg-primary rounded-pill">+</span>
                                </button>
                                <button type="button" class="btn_colec fw-bold list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                    Сообщения
                                    <span class="badge text-bg-primary rounded-pill">+</span>
                                </button>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">id: <?= $idUser?></li>
                                <li class="list-group-item">login: <?= $login?></li>
                                <li class="list-group-item">Имя: <?=$name?></li>
                            </ul>
                            <button type="button" class="btn_colec btn btn-primary">Редактировать</button>
                        </div>
                    </div>
                </div>
                <!-- Функциональный блок  -->
                <div class="m-3 accordion" id="accordionExample">
                    <div class="">
                        <div id="blok_1" class="blok collapse-horizontal collapse">
                            <div class="card" style="height:652px;">
                                <h5 class="card-header">Друзья</h5>
                                <div class="friends">
                                    <div class="tuble-friends">
                                        <?php get_users()?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div id="blok_2" class="blok collapse-horizontal collapse">
                            <div class="card" style="height: 652px;">
                                <h5 class="card-header">Заявки</h5>
                                <div class="zayvki">
                                    <div class="people1">
                                        Заявки
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div id="blok_3" class="blok collapse-horizontal collapse show">
                            <div class="card" style="height: 652px;">
                                <h5 class="card-header">Сообщения</h5>
                                <div class="messages">
                                    <div class="people">
                                        <?php get_list_message_user()?>
                                    </div>
                                    <div id="chat-box" class="correspondence" style="display:none;" >
                                        <div class="friend_up_block">
                                            <div class="friend-photo-chat">
                                                <img src="assets/img/zamer.png" alt="Фото друга">
                                            </div>
                                            <div class="friend-info-chat">
                                                <div class="friend-name-chat"><span id="selected-user-name"></span></div>
                                            </div>
                                            <div class="friend-action-menu">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="main_messages">
                                            <div class="overflow_masssages" id="chatBox">
                                            
                                            </div>
                                        </div>
                                        <div>
                                            <form>
                                                
                                                <input type="hidden" id="incoming_id">
                                                <div class="form_post_messages">
                                                    <div class="input_post_message">
                                                        <label for="file-upload" class="file-label"><img src="assets/img/free-icon-attach.png" alt=""></label>
                                                        <input type="file" id="file-upload" class="file-input">
                                                        <input id="message" name="message"></input>
                                                    </div>
                                                    <div>
                                                        <button class="btn_post_message" id="send-message-btn" type="submit">
                                                            <svg width="70" height="32" viewBox="0 0 465 427" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M454.82 214.612C454.82 214.612 455.013 214.706 454.772 214.594C447.008 214.594 333.293 214.584 234.304 214.576C239.725 182.242 241.995 149.455 238.487 114.091C343.939 162.934 447.89 211.386 454.772 214.594C455.158 214.647 454.969 214.552 454.82 214.612Z" fill="#0270D1"/>
                                                                <path d="M454.82 214.612C372.044 252.275 267.654 299.496 180.81 338.852C214.857 292.683 227.728 253.8 234.304 214.576C337.424 214.594 454.82 214.612 454.82 214.612Z" fill="#0270D1"/>
                                                                <path d="M83.2847 214.594C83.2847 214.594 8.93877 12.2417 10.048 10.0178C10.612 8.88707 125.59 61.8002 238.487 114.091C241.995 149.455 239.725 182.242 234.304 214.576C153.303 214.594 83.2847 214.594 83.2847 214.594Z" fill="#1E88E5"/>
                                                                <path d="M10.048 416.982C7.82968 419.206 83.2847 214.594 83.2847 214.594C142.443 214.572 173.056 214.573 231.236 214.576L234.304 214.576C227.728 253.8 214.857 292.683 180.81 338.852C85.4259 382.079 11.2091 415.818 10.048 416.982Z" fill="#1E88E5"/>
                                                                <path d="M454.82 214.612C454.82 214.612 347.626 164.642 238.487 114.091M454.82 214.612C372.044 252.275 267.654 299.496 180.81 338.852M454.82 214.612C454.82 214.612 337.424 214.594 234.304 214.576M454.82 214.612C454.82 214.612 455.013 214.706 454.772 214.594M454.82 214.612C454.969 214.552 455.158 214.647 454.772 214.594M83.2847 214.594C83.2847 214.594 8.93877 12.2417 10.048 10.0178C10.612 8.88707 125.59 61.8002 238.487 114.091M83.2847 214.594C83.2847 214.594 7.82968 419.206 10.048 416.982C11.2091 415.818 85.4259 382.079 180.81 338.852M83.2847 214.594C83.2847 214.594 153.303 214.594 234.304 214.576M83.2847 214.594C143.475 214.571 174.115 214.573 234.304 214.576M83.2847 214.594C142.432 214.572 176.043 214.573 234.304 214.576M83.2847 214.594C142.443 214.572 173.056 214.573 231.236 214.576L234.304 214.576M238.487 114.091C241.995 149.455 239.725 182.242 234.304 214.576M238.487 114.091C343.939 162.934 447.89 211.386 454.772 214.594M180.81 338.852C214.857 292.683 227.728 253.8 234.304 214.576M234.304 214.576C333.293 214.584 447.008 214.594 454.772 214.594M234.304 214.576L346.075 214.594H454.772" stroke="#0D47A1" stroke-width="19"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div id="blok_4" class="blok collapse-horizontal collapse ">
                            <div class="card" style="height:652px;">
                                <h5 class="card-header">Редактор Профиля</h5>
                                <div class="profile">
                                    <div class="edit_profile">
                                        <form class="row g-3 needs-validation" action="src/edit_profile.php" method="post">
                                            <div class="row">
                                                <div class="col-md-4"> 
                                                    <label for="validationCustom01" class="form-label">First name</label>
                                                    <input required type="name" name="name" class="form-control" value="<?= $name?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="validationCustom02" class="form-label">Surname</label>
                                                    <input required type="surname" name="surname"  class="form-control" value="<?= $surname?>">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label for="exampleInputEmail1" class="form-label"></label>
                                                    <input required type="login" name="login" class="form-control" id="exampleInputEmail1" value="<?= $login?>" placeholder="login">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <label for="exampleInputPassword1" class="form-label"></label>
                                                    <input required type="password" name="password" class="form-control" value="<?= $login?>"  placeholder="password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary"  type="submit">Сохранить</button>
                                            </div>
                                        </form>
                                        <br>
                                        <form method="post">
                                            <button class="btn btn-danger" name="editProfile" type="submit">Удалить аккаунт</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="card" data-bs-theme="dark">
            <h5 class="card-header">Footer</h5>
            <div class="container ">
            <div class="card-body">
                <h5 class="card-title">Техническая поддержка</h5>
                <p class="card-text">Свяжитесь с разработчиком, если у вас появились проблемы</p>
                <div class="mb-3">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="login">
                    </div>
                    <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Введите обращение</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <a href="#" class="btn btn-primary">Отправить</a>
            </div>
            </div>
        </div>
    </footer>
    <script src="src/app.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    
</body>
</html>