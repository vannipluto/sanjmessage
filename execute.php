<?php
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}

define("BOT_TOKEN", "659085083:AAHVwdPVn4E052VTv9z4yVFb7aLEZi5PPas");

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

if($text == "/start") {
  // start bot esco e non inoltro
  exit;
}

$botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/forwardMessage";

// change image name and path
// $postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath("image.png")), 'caption' => $text);

// chat_id: Unique identifier for the target chat or username of the target channel (in the format @channelusername)
// from_chat_id: Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
// message_id: Message identifier in the chat specified in from_chat_id

$postFieldsForFW = array('chat_id' => '@snjmsg2288', 'from_chat_id' => $chatId, 'message_id' => $messageId);

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
curl_setopt($ch, CURLOPT_URL, $botUrl); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFieldsForFW);

// read curl response
$output = curl_exec($ch);

$responseFW = "Messaggio inotrato, grazie!";

if(!$output['ok']) {
    $responseFW = "Messaggio non inviato, riprova piu' tardi ... :(";
}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $responseFW);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
?>
