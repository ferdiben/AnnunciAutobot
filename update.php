<?php
/**
 * Telegram Bot example.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
include 'Telegram.php';

// Set the bot TOKEN
$bot_token = '323852343:AAH5AZvSM5ceC60KSKIFVV-dHzHQgA7JnJg';
// Instances the class
$telegram = new Telegram($bot_token);

/* If you need to manually take some parameters
*  $result = $telegram->getData();
*  $text = $result["message"] ["text"];
*  $chat_id = $result["message"] ["chat"]["id"];
*/

// Take text and chat_id from the message
$text = $telegram->Text();
$chat_id = $telegram->ChatID();

// Test CallBack
$option = array( 
    //First row
    array($telegram->buildKeyboardButton("Button 1"), $telegram->buildKeyboardButton("Button 2")), 
    //Second row 
    array($telegram->buildKeyboardButton("Button 3"), $telegram->buildKeyboardButton("Button 4"), $telegram->buildKeyboardButton("Button 5")), 
    //Third row
    array($telegram->buildKeyboardButton("Button 6")) );
$keyb = $telegram->buildKeyBoard($option, $onetime=false);
$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "This is a Keyboard Test");
$telegram->sendMessage($content);
}
