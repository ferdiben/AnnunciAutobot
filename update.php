<?php
include 'Telegram.php';
include 'find.php';

error_reporting(E_ALL);
    ini_set('session.save_handler','redis');
    ini_set('session.save_path',"tcp://ec2-34-252-182-25.eu-west-1.compute.amazonaws.com:13419?auth=p05ebe76c4296539328f91efde721822040f16c9e599be903602914d21c27a55e");
  

// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);
session_start();
session_id($chat_id);
$_SESSION['sessionid'] = session_id();


Parametri($text, $chat_id);

$ciao = setParametri();
$option = array( 
    //First row
    array($telegram->buildKeyboardButton("Button 1"), $telegram->buildKeyboardButton("Button 2")), 
    //Second row 
    array($telegram->buildKeyboardButton("Button 3"), $telegram->buildKeyboardButton("Button 4"), $telegram->buildKeyboardButton("Button 5")), 
    //Third row
    array($telegram->buildKeyboardButton("Button 6")) );
$keyb = $telegram->buildKeyBoard($option, $onetime=false);


$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => session_id().$_SESSION[session_id()]['modello'].$_SESSION['regione'].$_SESSION['provincia'].$_SESSION['alimentazione']);
$telegram->sendMessage($content);
?>
