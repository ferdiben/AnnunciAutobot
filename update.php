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
$username = $result["message"]["chat"]["first_name"];

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

//if(!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]) && !isset($_SESSION["prezzo"])){
//Parametri($text, $chat_id);
//}


$questions = setParametri();

if($callback_query["data"] === "new" || $text === "/nuova_ricerca"){
    session_destroy();
} elseif($callback_query["data"] === "skip"){
    $_SESSION["$i"]++;
} 

$option = array( 
    //First row
    array($telegram->buildInlineKeyBoardButton("Visualizza Auto", $url="https://annunciautobot.herokuapp.com/cerca.php?marca=".$_SESSION["marca"]."&modello=".$_SESSION["modello"]."&regione=".$_SESSION["regione"]."&provincia=".$_SESSION["provincia"]."&alimentazione".$_SESSION["alimentazione"]."=&prezzo=".$_SESSION["prezzo"], $callback_data="eseguiricerca", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Skip", $url="", $callback_data1="skip", $switch_inline_query=true, $switch_inline_query_current_chat=null), $telegram->buildInlineKeyBoardButton("Nuova Ricerca", $url="", $callback_data2="new", $switch_inline_query=true, $switch_inline_query_current_chat=null)));
$keyb = $telegram->buildInlineKeyBoard($option);

if ($text === "/start" || $text === "/nuova_ricerca" || $callback_query["data"] === "new" || (!isset($_SESSION["marca"]) && !isset($_SESSION["modello"]) && !isset($_SESSION["regione"]) && !isset($_SESSION["provincia"]) && !isset($_SESSION["alimentazione"]) && !isset($_SESSION["prezzo"]))){
        $_SESSION["$i"]=0;
    $content = array('chat_id' => $chat_id, 'text' => "Ciao ".$username."! Inserisci l'auto da cercare");
} else {
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Parametri Ricerca:"."\nMarca:  ".ucfirst($_SESSION["marca"])."\nModello:  ".ucfirst($_SESSION["modello"])."\nRegione:  ".ucfirst($_SESSION["regione"])."\nProvincia:  ".ucfirst($_SESSION["provincia"])."\nAlimentazione:  ".ucfirst($_SESSION["alimentazione"])."\nPrezzo:  ".$_SESSION["prezzo"]."\n"."_._._._._._._._._._._"."\nLa tua ricerca ha prodotto ".$_SESSION['count']."  risultati"."\n"."_._._._._._._._._._._\n".$_SESSION['total_elements'][$_SESSION["$i"]]);
}

$telegram->sendMessage($content);
?>
