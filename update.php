<?php
include 'Telegram.php';
include 'find.php';

error_reporting(E_ALL);  
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

Parametri($text, $chat_id);

$questions = setParametri();
$option = array( 
    //First row
    array($telegram->buildInlineKeyBoardButton("Esegui Ricerca", $url="http://google.it", $callback_data="myCallbackText", $switch_inline_query=null, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url="http://linj321.it", $callback_data="myCallbackText", $switch_inline_query=null, $switch_inline_query_current_chat=null)),
array($telegram->buildInlineKeyBoardButton("Esegui Ricerca", $url="", $callback_data="myCallbackText", $switch_inline_query=null, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url='', $callback_data='myCallback1', $switch_inline_query=null, $switch_inline_query_current_chat=null)));

$keyb = $telegram->buildInlineKeyBoard($option);

if ($text === "/start" || (!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]))){
    $content = array('chat_id' => $chat_id, 'text' => "Benvenuto! Inserisci l'auto da cercare");
} else {
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $questions[0]);
}
$telegram->sendMessage($content);
?>
