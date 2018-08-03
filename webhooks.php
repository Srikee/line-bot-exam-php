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
			
			$map = map_data($event['message']['text']);
			send($event, $map[0], $map[1]);
/*
			switch($event['message']['text'])	{
				case "เปิดอุปกรณ์ 1xx" : send($event, "เปิดอุปกรณ์ 1 แล้วค่ะ", "http://kscyber.ddns.net/?D=1&I=1"); break;
				case "ปิดอุปกรณ์ 1" : send($event, "ปิดอุปกรณ์ 1 แล้วค่ะ", "http://kscyber.ddns.net/?D=1&I=0"); break;
				case "เปิดอุปกรณ์ 2" : send($event, "เปิดอุปกรณ์ 2 แล้วค่ะ", "http://kscyber.ddns.net/?D=2&I=1"); break;
				case "ปิดอุปกรณ์ 2" : send($event, "ปิดอุปกรณ์ 2 แล้วค่ะ", "http://kscyber.ddns.net/?D=2&I=0"); break;
				case "เปิดอุปกรณ์ 3" : send($event, "เปิดอุปกรณ์ 3 แล้วค่ะ", "http://kscyber.ddns.net/?D=3&I=1"); break;
				case "ปิดอุปกรณ์ 3" : send($event, "ปิดอุปกรณ์ 3 แล้วค่ะ", "http://kscyber.ddns.net/?D=3&I=0"); break;
				case "เปิดทั้งหมด" : send($event, "เปิดทั้งหมด แล้วค่ะ", "http://kscyber.ddns.net/open_all"); break;
				case "ปิดทั้งหมด" : send($event, "ปิดทั้งหมด แล้วค่ะ", "http://kscyber.ddns.net/close_all"); break;
				default : send($event, "ไม่พบคำสั่ง\n\nพิมพ์คำสั่งดังนี้นะค่ะ\nเปิดอุปกรณ์ 1\nเปิดอุปกรณ์ 2\nเปิดอุปกรณ์ 3\nปิดอุปกรณ์ 1\nปิดอุปกรณ์ 2\nปิดอุปกรณ์ 3\nเปิดทั้งหมด\nปิดทั้งหมด"); break;
			}*/
		}
	}
}
echo "OK";
function map_data($text) {
	$arr = array(
		array(
			"text"=>"เปิดไฟ",
			"similar"=>array("เปิดอุปกรณ์หนึ่ง", "เปิด 1", "เปิดหนึ่ง", "เปิดไฟ 1", "เปิดไฟหนึ่ง"),
			"url"=>"http://188.166.206.43/2489cb10e87b42579203a17636ad804a/update/D16?value=1"
		),
		array(
			"text"=>"เปิดพัดลม",
			"similar"=>array("เปิดอุปกรณ์สอง", "เปิด 2", "เปิดสอง", "เปิดไฟ 2", "เปิดไฟสอง"),
			"url"=>"http://188.166.206.43/2489cb10e87b42579203a17636ad804a/update/D5?value=1"
		),
		array(
			"text"=>"เปิดอุปกรณ์ 3",
			"similar"=>array("เปิดอุปกรณ์สาม", "เปิด 3", "เปิดสาม", "เปิดไฟ 3", "เปิดไฟสาม"),
			"url"=>"http://188.166.206.43/2489cb10e87b42579203a17636ad804a/update/D4?value=1"
		),
		array(
			"text"=>"ปิดไฟ",
			"similar"=>array("ปิดอุปกรณ์หนึ่ง", "ปิด 1", "ปิดหนึ่ง", "ปิดไฟ 1", "ปิดไฟหนึ่ง"),
			"url"=>"http://188.166.206.43/2489cb10e87b42579203a17636ad804a/update/D16?value=0"
		),
		array(
			"text"=>"ปิดพัดลม",
			"similar"=>array("ปิดอุปกรณ์สอง", "ปิด 2", "ปิดสอง", "ปิดไฟ 2", "ปิดไฟสอง"),
			"url"=>"http://188.166.206.43/2489cb10e87b42579203a17636ad804a/update/D5?value=0"
		),
		array(
			"text"=>"ปิดอุปกรณ์ 3",
			"similar"=>array("ปิดอุปกรณ์สาม", "ปิด 3", "ปิดสาม", "ปิดไฟ 3", "ปิดไฟสาม"),
			"url"=>"http://188.166.206.43/2489cb10e87b42579203a17636ad804a/update/D4?value=0"
		),
		array(
			"text"=>"เปิดทั้งหมด",
			"similar"=>array("เปิดทุกอย่าง", "เปิดทุกตัว", "เปิดหมด"),
			"url"=>"http://kscyber.ddns.net/open_all"
		),
		array(
			"text"=>"ปิดทั้งหมด",
			"similar"=>array("ปิดทุกอย่าง", "ปิดทุกตัว", "ปิดหมด"),
			"url"=>"http://kscyber.ddns.net/close_all"
		),
	);
	foreach ($arr as $key => $value) {
		$t = $value["text"];
		if( $t==$text ) return array($t." แล้วค่ะ", $value["url"]);
		foreach ($value["similar"] as $key2 => $value2) {
			if( $value2==$text ) return array($t." แล้วค่ะ", $value["url"]);
		}
	}
	return array($t."ไม่พบคำสั่ง\n\nพิมพ์คำสั่งดังนี้นะค่ะ\nเปิดอุปกรณ์ 1\nเปิดอุปกรณ์ 2\nเปิดอุปกรณ์ 3\nปิดอุปกรณ์ 1\nปิดอุปกรณ์ 2\nปิดอุปกรณ์ 3\nเปิดทั้งหมด\nปิดทั้งหมด", "");
}
function get_content($arr_data) {
	$url = $arr_data["url"];
	$postdata = http_build_query($arr_data);
	$opts = array('http' =>
		array(
			'method'  => 'GET',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);
	$context = stream_context_create($opts);
	return file_get_contents($url, false, $context);
}
function send($event, $message, $url="") {
	$data2 = [
		'replyToken' => $event['replyToken'],
		'messages' => [[
			'type' => 'text',
			'text' => $message
		]],
	];
	post($data2);
	if( $url!="" ) {
		$data1 = array(
			"url" => $url,
		);
		$result = get_content($data1);
	}
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
