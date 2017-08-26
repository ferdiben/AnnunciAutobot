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


$text = trim($text);
$text = strtolower($text);

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => "vaffanculo");
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
