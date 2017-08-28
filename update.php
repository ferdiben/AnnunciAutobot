<?php
include 'Telegram.php';
// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
$telegram = new Telegram($bot_token);
$chat_id = $telegram->ChatID();

  $connection = new MongoClient('mongodb://SvensonTeam:Capracotta.1@ds157833.mlab.com:57833/annunciauto');
    $database   = $connection->selectDB('annunciauto');
    $collection = $database->selectCollection('Marche_Modelli');


$i = 0;
$cursor = $collection->find();
foreach ($cursor as $key) {
    $marche[$i] = $key['marca'];
  $i++;
  var_dump($marche);
}

$option = array( 
    //First row
    $marche );
$keyb = $telegram->buildKeyBoard($option, $onetime=false);
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "This is a Keyboard Test");
$telegram->sendMessage($content);
?>
