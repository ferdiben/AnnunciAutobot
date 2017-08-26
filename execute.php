<?php

use Telegram\Bot\Api;

$telegram = new Api('323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg');

$response = $telegram->forwardMessage([
  'chat_id' => 'CHAT_ID', 
  'from_chat_id' => 'FROM_CHAT_ID',
	'message_id' => 'MESSAGE_ID'
]);

$messageId = $response->getMessageId();

?>
