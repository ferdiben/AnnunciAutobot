<?php
include 'Telegram.php';

  $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
    $database   = $connection->selectDB('annunciauto');
    $Marche_Modelli = $database->selectCollection('Marche_Modelli');
    $Regioni_Province = $database->selectCollection('Regioni_Province');
    $Alimentazione = $database->selectCollection('Alimentazione');
    $Auto = $database->selectCollection('Auto');
    $Utenti = $database->selectCollection('Utente');



// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();
$result = $telegram->getData();
$text = $result["message"]["text"];
$text = trim($text);
$text = strtolower($text);

$i = 0;
$cursor = $collection->find();
foreach ($cursor as $key) {
    $marche[$i] = $key['marca'];
  $i++;
  var_dump($marche);
}

$i = 0;
$cursor = $collection->find();
foreach ($cursor as $key) {
    $marche[$i] = $key['marca'];
  $i++;
  var_dump($marche);
}
  
switch ($parametri) {
    case "marca":
         $_SESSION["marca"] = $marca;
        break;
    case "modello":
$_SESSION["modello"] = $modello;
        break;
    case "regione":
$_SESSION["regione"] = $regione;
        break;
    case "provincia":
$_SESSION["provincia"] = $provincia;
        break;
    case "alimentazione":
$_SESSION["alimentazione"] = $alimentazione;
        break;
}


$option = array( 
    //First row
    $marche );
$keyb = $telegram->buildKeyBoard($option, $onetime=false);
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "This is a Keyboard Test");
$telegram->sendMessage($content);
?>
