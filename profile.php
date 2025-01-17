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

// вызывается функция получение всех users в вкладке сообщения. 
function get_list_message_user(){
    $idUser = $_SESSION['user']['id'];
                  
    $sql_friend = "SELECT * FROM `users` WHERE NOT `id` = ('$idUser')";

    $result_friend = mysqli_query(getDB(), $sql_friend );
    
    if (!$result_friend == ''){
        foreach ($result_friend as $item){
            echo('
                <a class="massage-friend user-item" data-user-id="'.$item['id'].'">
                    <div class="massage-friend-photo">
                        <img src="assets/img/zamer.png" alt="Фото друга">
                    </div>
                    <div class="friend-info">
                        <div id = "name" class="friend-name">'. $item['name'].'</div>
                        <div class="friend-message"></div>
                    </div>
                    <div class="friend-notification">
                        <div class="notification-count">defold</div>
                        <div class="notification-time">defold</div>
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
                <div class="friend" >
                    <div class="friend-photo">
                        <img src="assets/img/zamer.png" alt="Фото друга">
                    </div>
                    <div class="friend-info">
                        <div class="friend-name">'. $item['name']. ' '. $item['surname'].'</div>
                        <a href="" class="contact-friend">Написать сообщение</a>
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
                <div class="m-3">
                    <div class="card" style="width: 18rem;">
                        <img src="/assets/img/profile.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                        <div class="list-group">
                            <button type="button" class="btn_colec fw-bold list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                Друзья
                                <span class="badge text-bg-primary rounded-pill">6</span>
                            </button>
                            <button type="button" class="btn_colec fw-bold list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                Заявки
                                <span class="badge text-bg-primary rounded-pill">3</span>
                            </button>
                            <button type="button" class="btn_colec fw-bold list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                Сообщения
                                <span class="badge text-bg-primary rounded-pill">999</span>
                            </button>
                        </div>
                        <br>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">id: <?= $idUser?></li>
                            <li class="list-group-item">login: <?= $login?></li>
                            <li class="list-group-item">unique_id: <?=$unique_id?></li>
                        </ul>
                        <br>
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
                                            <div class="massage-friend-photo">
                                                <img src="assets/img/zamer.png" alt="Фото друга">
                                            </div>
                                            <div class="friend-info">
                                                <div class="friend-name"><span id="selected-user-name"></span></div>
                                            </div>
                                            <div class="friend-notification">
                                                ...
                                            </div>
                                        </div>
                                        <div class="main_messages">
                                            <div class="overflow_massages" id="chatBox">
                                                
                                            </div>  
                                        </div>
                                        <div class="input_post_messages">
                                            <div class="bg-body-tertiary">
                                                <div class="container-fluid">
                                                    <form class="d-flex" >
                                                        <input type="hidden" id="incoming_id">
                                                        <textarea id="message" class="form-control me-2" name="message"></textarea>
                                                        <button id="send-message-btn"class="btn btn-outline-success" type="submit">Отправить</button>
                                                    </form>
                                                </div>
                                            </div>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        
    </script> -->
</body>
</html>