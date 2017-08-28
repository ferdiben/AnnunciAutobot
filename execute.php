<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


    $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
    $database   = $connection->selectDB('annunciauto');
    $collection = $database->selectCollection('Marche_Modelli');


// recupero il contenuto inviato da Telegram
$content = file_get_contents("php://input");
// converto il contenuto da JSON ad array PHP
$update = json_decode($content, true);
// se la richiesta è null interrompo lo script
if(!$update)
{
  exit;
}
// assegno alle seguenti variabili il contenuto ricevuto da Telegram
$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";
// pulisco il messaggio ricevuto togliendo eventuali spazi prima e dopo il testo
$text = trim($text);
// converto tutti i caratteri alfanumerici del messaggio in minuscolo
$text = strtolower($text);
// mi preparo a restitutire al chiamante la mia risposta che è un oggetto JSON
// imposto l'header della risposta
header("Content-Type: application/json");
// la mia risposta è un array JSON composto da chat_id, text, method
// chat_id mi consente di rispondere allo specifico utente che ha scritto al bot
// text è il testo della risposta


$i = 0;
$cursor = $collection->find();
foreach ($cursor as $key) {
    $marche[$i] = $key['marca'];
  $i++;
}
$r = "jasf";
$f = json_encode(array($marche));
 $arr = array('keyboard' => $marche);
$data = json_encode($arr);

$arr1 = array('one_time_keyboard' => false);
$data1 = json_encode($arr);
 
//echo $data;
$parameters = array('chat_id' => $chatId, "text" => $marche[1]);
// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
$myObj->keyboard = $marche;
$myObj->one_time_keyboard = false;
$param = json_encode($myObj);

$keyboradsValue = array(
   array("button 1","button 2"),
   array("button 3","button 4"),
);
$parameters = array(
  'keyboard' => $keyboradsValue,
  'force_reply' => true,
  'selective' => true
);
// imposto la keyboard
$parameters["method"] = "sendMessage";

// converto e stampo l'array JSON sulla response
echo json_encode($parameters);


?>
