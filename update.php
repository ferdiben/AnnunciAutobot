<?php
include 'Telegram.php';
include 'find.php';

if($_ENV['REDIS_URL']) {
    $redisUrlParts = parse_url($_ENV['REDIS_URL']);
    ini_set('session.save_handler','redis');
    ini_set('session.save_path',"tcp://$redisUrlParts[ec2-34-252-182-25.eu-west-1.compute.amazonaws.com]:$redisUrlParts[13419]?auth=$redisUrlParts[Capracotta.1]");
  }

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
