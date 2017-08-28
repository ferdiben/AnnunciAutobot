<?php


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);
$encodedMarkup = '';
$replyMarkup = array(
    'keyboard' => array(
        array("A", "B")
    )
);
$encodedMarkup = json_encode($replyMarkup);
$parameters = array(
    'chat_id' => $chatId,
    'reply_markup' => $encodedMarkup,
    'text' => "Test"
);
$parameters["method"] = "sendMessage";



echo json_encode($parameters);

?>
