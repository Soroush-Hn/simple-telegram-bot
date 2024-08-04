<?php
require_once realpath(__DIR__."/vendor/autoload.php");
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$result = $dotenv->load();
$token = $result["TOKEN"];
include 'telegram.php';
$telegram = new Telegram($token);
$url = "https://e827f853-d663-44ef-9ae0-ac86e14ba08b-00-3exf2zyktmvj3.picard.replit.dev/index.php";
$json_webhook_isset = $telegram->setWebhook($url);
// result request body{}
$result = $telegram->getData();

$chat_id = $telegram->ChatID();
$text    = $telegram->Text();

$myCommands = false;

if($text == "/start") {
	$option = array(
		//First row
		array($telegram->buildInlineKeyBoardButton("شروع😎", '', '/home')),
	);
	$keyb = $telegram->buildInlineKeyBoard($option);
	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "سلام خوبی؟ به ربات چنگ دل خوش اومدی!");
	$telegram->sendMessage($content);
}

if($text == "/home" || $text == "شروع😎" || $text == "بازگشت🔙") {
	// true myCommands (bool)
	$myCommands = true;

	// send welcome mesasage& create keyboard
	$option = [
		//First row
		//        array($telegram->buildInlineKeyBoardButton("شروع😎", '', '/start')),
		//Second row
		array($telegram->buildInlineKeyBoardButton("اطلاعات ربات🤖", '', '/info'), $telegram->buildInlineKeyBoardButton("اطلاعات شخصی🧑‍🦲", '', '/me')),
		////testing
		array($telegram->buildInlineKeyBoardButton("vid", '', '/vid'), $telegram->buildInlineKeyBoardButton("pic", '', '/pic'))
	];
	$keyb = $telegram->buildInlineKeyBoard($option);
	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "سلام خوبی؟ به ربات سبزلرن خوش اومدی!",  'message_id'=> $result['callback_query']['message']['message_id']);
	$telegram->editMessageText($content);
}


if($text == '/vid' || $text == "vid"){
	$vid = curl_file_create('vid/Cigarettes.mp4', 'video/mp4', 'Cigarettes.mp4'); 
	$content = array('chat_id' => $chat_id, 'video' => $vid );
	$telegram->sendVideo($content);
}


if($text == '/pic' || $text == "pic"){
	$img = curl_file_create('pic/midjourney.png', 'image/png', 'midjourney.png'); 
	$content = array('chat_id' => $chat_id, 'photo' => $img );
	$telegram->sendPhoto($content);
}


if($text == "/info" || $text == "اطلاعات ربات🤖") {
	$myCommands = true;
	$option = array(
		//First row
		array($telegram->buildInlineKeyBoardButton("بازگشت🔙", '', '/home')),
	);
	$keyb = $telegram->buildInlineKeyBoard($option);
	$myResult = $telegram->getMe()['result']['first_name'];
	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $myResult, 'message_id'=> $result['callback_query']['message']['message_id']);
	$telegram->editMessageText($content);
}

if($text == "/me" || $text == "اطلاعات شخصی🧑‍🦲") {
	$myCommands = true;

	$option = array(
		//First row
		array($telegram->buildInlineKeyBoardButton("بازگشت🔙", '', '/home')),
	);
	$keyb = $telegram->buildInlineKeyBoard($option);
	$myResult = $telegram->Chat()['first_name'];
	$content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => $myResult, 'message_id'=> $result['callback_query']['message']['message_id']);
	$telegram->editMessageText($content);
}


