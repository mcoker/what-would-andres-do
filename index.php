<?php

include "token.php";

$data = json_decode(file_get_contents('php://input'), true);
// This is used for validation when creating bot
//print_r(json_decode($data));

$url = 'https://slack.com/api/chat.postMessage';
$text = $data['event']['text'];
$channel = $data['event']['channel'];
$user = $data['event']['user'];

$quotes = array(
	'Close your eyes and hit merge!',
	'Eat more cake.',
	'Needs more transclusion.',
	'Blame Dana.'
);

$matches = array( 
	'wwad\?',
	'what would andres do',
	'what andres would do'
);

if (preg_match('/(' . join('|', $matches) . ')/i', $text)) {

	$content = json_encode(array(
		'text' => '<@' . $user . '> ' . $quotes[array_rand($quotes)],
		'channel' => $channel
	));

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-type: application/json',
		'Authorization: Bearer ' . $token
	));
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

	$json_response = curl_exec($curl);

	$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	curl_close($curl);

}

?>
