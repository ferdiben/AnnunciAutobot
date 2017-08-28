<?php
include 'Telegram.php';
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$content = array('chat_id' => $chat_id, 'text' => "Test");
$telegram->sendMessage($content);
?>
