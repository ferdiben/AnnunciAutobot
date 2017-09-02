<?php
include 'Telegram.php';
include 'find.php';

error_reporting(E_ALL);  
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
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
if($callback_query["data"] === "eseguiricerca"){
        session_destroy();
} elseif($callback_query["data"] === "skip"){
        $_SESSION["$i"]++;
}

$option = array( 
    //First row
    array($telegram->buildInlineKeyBoardButton("Esegui Ricerca", $url="https://annunciautobot.herokuapp.com/cerca.php?marca=".$_SESSION["marca"]."&modello=".$_SESSION["modello"]."&regione=".$_SESSION["regione"]."&provincia=".$_SESSION["provincia"]."&alimentazione".$_SESSION["alimentazione"]."=&prezzo=".$_SESSION["prezzo"], $callback_data="eseguiricerca", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url="", $callback_data1="skip", $switch_inline_query=true, $switch_inline_query_current_chat=null)));

$keyb = $telegram->buildInlineKeyBoard($option);

if ($text === "/start" || (!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]) && !isset($_SESSION["prezzo"]))){
        $_SESSION["$i"]=0;
    $content = array('chat_id' => $chat_id, 'text' => "Benvenuto! Inserisci l'auto da cercare");
} else {
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Parametri Ricerca:"."\nMarca:  ".$_SESSION["marca"]."\nModello:  ".$_SESSION["modello"]."\nRegione:  ".$_SESSION["regione"]."\nProvincia:  ".$_SESSION["provincia"]."\nAlimentazione:  ".$_SESSION["alimentazione"]."\nPrezzo:  ".$_SESSION["prezzo"]."\n".$_SESSION['total_elements'][$_SESSION["$i"]]);
}

$telegram->sendMessage($content);
?>
