<?php

use Telegram\Bot\Api;

$telegram = new Api('323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg');

$response = Telegram->getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$username = $response->getUsername();

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
