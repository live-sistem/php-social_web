<?php
session_start();
require_once __DIR__ . '/helpers.php';
$connect = getDB();

$outgoing_id  = $_SESSION['user']['id'];

$incoming_id = $_GET['user_id'];

$output = "";

$sql_messages = "SELECT * FROM messages LEFT JOIN users ON users.id = messages.outgoing_msg_id
WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id})";

$result_messages = mysqli_query($connect, $sql_messages);
    if (mysqli_num_rows($result_messages)>0){
        while ($row = mysqli_fetch_assoc($result_messages)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                $output .= '<div class="messages_block_right">
                    <div class="messages_post_right">
                        '. $row['msg'] .'
                    </div>
                </div>';
            }
            else {
                $output .= '<div class="messages_block_left">
                    <div class="messages_post_left">
                        '. $row['msg'] .'
                    </div>
                </div>';
                
            }
        }
    }
    else{
        $output .= '<div class="text">Нет доступных сообщений. После отправки сообщений они появятся здесь.</div>';
    }
echo $output;

?>

