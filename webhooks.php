<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'R27qpC+nfEewcJovnr0ORUia5hIRgZHRWEkjEqY9cARAWEk20r4I6s+3OkiTKzmN+AUXTBp+GsueSi+krTQbXrIXte/Cv0vV/phIAZrrtCiXhJcZTKd93R6iq9Xrllt/XZtBQibFA7x10F2Eh9TLHgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			//$userId = $event['source']['userId'];
			switch($event['message']['text'])	{
				case "เปิดอุปกรณ์ 1" : send($event, "เปิดอุปกรณ์ 1 แล้วค่ะ", "http://kscyber.ddns.net/?D=1&I=1"); break;
				case "ปิดอุปกรณ์ 1" : send($event, "ปิดอุปกรณ์ 1 แล้วค่ะ", "http://kscyber.ddns.net/?D=1&I=0"); break;
				case "เปิดอุปกรณ์ 2" : send($event, "เปิดอุปกรณ์ 2 แล้วค่ะ", "http://kscyber.ddns.net/?D=2&I=1"); break;
				case "ปิดอุปกรณ์ 2" : send($event, "ปิดอุปกรณ์ 2 แล้วค่ะ", "http://kscyber.ddns.net/?D=2&I=0"); break;
				case "เปิดอุปกรณ์ 3" : send($event, "เปิดอุปกรณ์ 3 แล้วค่ะ", "http://kscyber.ddns.net/?D=3&I=1"); break;
				case "ปิดอุปกรณ์ 3" : send($event, "ปิดอุปกรณ์ 3 แล้วค่ะ", "http://kscyber.ddns.net/?D=3&I=0"); break;
				case "เปิดทั้งหมด" : send($event, "เปิดทั้งหมด แล้วค่ะ", "http://kscyber.ddns.net/open_all"); break;
				case "ปิดทั้งหมด" : send($event, "ปิดทั้งหมด แล้วค่ะ", "http://kscyber.ddns.net/close_all"); break;
				default : send($event, "ไม่พบคำสั่ง\nเปิดอุปกรณ์ 1\nเปิดอุปกรณ์ 2"); break;
			}
		}
	}
}
echo "OK";
function send($event, $message, $url="") {
	$data = [
		'replyToken' => $event['replyToken'],
		'messages' => [[
			'type' => 'text',
			'text' => $message
		]],
	];
	post($data);
}
function post($data) {
	global $access_token;
	// Make a POST Request to Messaging API to reply to sender
	$url = 'https://api.line.me/v2/bot/message/reply';
	$post = json_encode($data);
	$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$result = curl_exec($ch);
	curl_close($ch);
	echo $result . "\r\n";
}
