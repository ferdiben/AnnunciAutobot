<?php
include 'Telegram.php';
include 'find.php';

error_reporting(E_ALL);  
// Set the bot TOKEN
$bot_token = '967441932:AAF4ApETfl-uP5SdnaT98cDDNBg9LEgO8Gw';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$timestamp = $telegram->Date();
$callback_query = $telegram->Callback_Query();
$username = $result["message"]["chat"]["first_name"];
$data = gmdate("H", $timestamp) + 2;
ob_start();
var_dump($result);
$result1 = ob_get_clean();

$file = 'file.txt';
$current = file_get_contents($file);
$current .= $result1;
file_put_contents($file, $current);

$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

Parametri($text, $chat_id); 


$questions = setParametri();


if ($text === "/casa" ){
    $content = "Top of the Hops";
} if ($text === "/piace" ){
    $content = "La birra";
}

$telegram->sendMessage($content);
?>
