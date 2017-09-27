<?php
include 'Telegram.php';
include 'find.php';

error_reporting(E_ALL);  
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
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

if($data >= 4 && $data <= 13){
$saluto = "Buongiorno ";
}else{
$saluto = "Buon pomeriggio "; 
}
if($callback_query["data"] === "new" || $text === "/nuova_ricerca"){
    session_destroy();
} elseif($callback_query["data"] === "skip"  && (intval($_SESSION["$i"])%2 == 0)){
    $_SESSION["$i"] = $_SESSION["$i"] + 2;
} elseif($text === "si"){
    $_SESSION["$i"]++;
} elseif($callback_query["data"] === "skip" && (intval($_SESSION["$i"])%2 != 0)){
     $_SESSION["$i"]++;
} elseif($text === "no" && (intval($_SESSION["$i"])%2 != 0)){
     $_SESSION["$i"]++;
} elseif($text === "no" && (intval($_SESSION["$i"])%2 == 0)){
    $_SESSION["$i"] = $_SESSION["$i"] + 2;
} else {
    $_SESSION["$i"]++;
}

if(isset($_SESSION["regione"])){
$regione = "in ".ucfirst($_SESSION["regione"]);
} else{
$regione = "";
}
if(isset($_SESSION["provincia"])){
$provincia = "nella provincia di ".ucfirst($_SESSION["provincia"]);
} else{
$provincia = "";
}
if(isset($_SESSION["alimentazione"])){
$alimentazione = "alimentata a ".ucfirst($_SESSION["alimentazione"]);
} else{
$alimentazione = "";
}
if(isset($_SESSION["prezzo"])){
$prezzo = "a partire da ".$_SESSION["prezzo"]."€";
} else{
$prezzo = "";
}

if(isset($_SESSION["marca"]) && isset($_SESSION["modello"]) && isset($_SESSION["regione"]) && isset($_SESSION["provincia"]) && isset($_SESSION["alimentazione"]) && isset($_SESSION["prezzo"])){
    $option = array( 
    array($telegram->buildInlineKeyBoardButton("Visualizza Auto", $url="https://annunciautobot.herokuapp.com/cerca.php?marca=".$_SESSION["marca"]."&modello=".$_SESSION["modello"]."&regione=".$_SESSION["regione"]."&provincia=".$_SESSION["provincia"]."&alimentazione".$_SESSION["alimentazione"]."=&prezzo=".$_SESSION["prezzo"], $callback_data="eseguiricerca", $switch_inline_query=true, $switch_inline_query_current_chat=null)));
    $keyb = $telegram->buildInlineKeyBoard($option);
} else{
    $option = array(
    array($telegram->buildInlineKeyBoardButton("Visualizza Auto", $url="https://annunciautobot.herokuapp.com/cerca.php?marca=".$_SESSION["marca"]."&modello=".$_SESSION["modello"]."&regione=".$_SESSION["regione"]."&provincia=".$_SESSION["provincia"]."&alimentazione".$_SESSION["alimentazione"]."=&prezzo=".$_SESSION["prezzo"], $callback_data="eseguiricerca", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url="", $callback_data1="skip", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Nuova Ricerca", $url="", $callback_data2="new", $switch_inline_query=true, $switch_inline_query_current_chat=null)));
$keyb = $telegram->buildInlineKeyBoard($option);
}
if ($text === "/start" || $text === "/nuova_ricerca" || $callback_query["data"] === "new" || (!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]) && !isset($_SESSION["prezzo"]))){
        $_SESSION["$i"]=0;
    $content = array('chat_id' => $chat_id, 'text' => $saluto.$username."! Inserisci l'auto da cercare");
} else {
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Stai Cercando:"."\n".ucfirst($_SESSION["marca"])." ".ucfirst($_SESSION["modello"])." ".$regione." ".$provincia." ".$alimentazione." ".$prezzo."\n"."_._._._._._._._._._._"."\nIn base alle tue richieste ho trovato ".$_SESSION['count']."  annunci"."\n"."_._._._._._._._._._._\n".$_SESSION['total_elements'][$_SESSION["$i"]]);
}

$telegram->sendMessage($content);
?>
