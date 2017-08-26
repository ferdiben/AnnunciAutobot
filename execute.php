<?php
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
// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
;
// converto e stampo l'array JSON sulla response

 //   $parameters = array('chat_id' => $chatId, "text" => "ciao".$text);
//    $parameters["method"] = "sendMessage";
//echo json_encode($parameters);


$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

$reply_markup = $telegram->replyKeyboardMarkup([
    'keyboard' => $keyboard, 
    'resize_keyboard' => true, 
    'one_time_keyboard' => true
]);

$response = $telegram->sendMessage([
    'chat_id' => $chatId, 
    'text' => 'Hello World', 
    'reply_markup' => $reply_markup
]);

$messageId = $response->getMessageId();








?>
