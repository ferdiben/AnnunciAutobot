<?php
include 'Telegram.php';
include 'find.php';


// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

Parametri($text);

$option = array($marche);
$keyb = $telegram->buildKeyBoard($option, $onetime=false);
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $_SESSION["marca"]);
$telegram->sendMessage($content);
?>
