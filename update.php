<?php
include 'Telegram.php';
include 'find.php';
session_start();
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

Parametri($text);

$ciao = setParametri();
$option = array( 
    //First row
    array($telegram->buildKeyboardButton("Button 1"), $telegram->buildKeyboardButton("Button 2")), 
    //Second row 
    array($telegram->buildKeyboardButton("Button 3"), $telegram->buildKeyboardButton("Button 4"), $telegram->buildKeyboardButton("Button 5")), 
    //Third row
    array($telegram->buildKeyboardButton("Button 6")) );
$keyb = $telegram->buildKeyBoard($option, $onetime=false);


$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $ciao[0].$ciao[1].$ciao[2].$ciao[3]);
$telegram->sendMessage($content);
?>
