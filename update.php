<?php
include 'Telegram.php';
include 'find.php';

error_reporting(E_ALL);  
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$b =  $result["message"]["reply_markup"];
$callback_query = $telegram->Callback_Query();
$a = $callback_query["data"];



$file = 'file.txt';
$current = file_get_contents($file);
$current .= "ciao";
file_put_contents($file, $current);


$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

Parametri($text, $chat_id);

$questions = setParametri();
$option = array( 
    //First row
    array($telegram->buildInlineKeyBoardButton("Esegui Ricerca", $url="", $callback_data="ciao", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url="", $callback_data1="stronzo", $switch_inline_query=true, $switch_inline_query_current_chat=null)));

$keyb = $telegram->buildInlineKeyBoard($option);

if ($text === "/start" || (!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]))){
    $content = array('chat_id' => $chat_id, 'text' => "Benvenuto! Inserisci l'auto da cercare");
} else {
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $questions[0].$a);

}
$telegram->sendMessage($content);
?>
