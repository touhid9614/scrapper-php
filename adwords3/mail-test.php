<?php

$mailgun_api_key = 'key-5d6a8ed775f4d239f0fcf3f8fbc07963';
$domain = 'mail.smedia.ca';
/*
$mailgun = new Mailgun($mailgun_api_key, new \Http\Adapter\Guzzle6\Client());
$mailgun->setApiVersion('v3');
$mailgun->setSslEnabled(true);

$params = [
    'from'      => 'sMedia Smart Offer Lead<offers@smedia.ca>',
    'to'        => 'tanvir@smedia.ca',
    'subject'   => '#01 Test Lead Subject',
    'html'      => 'Hello,<p>This is test lead message</p>'
];

$response = $mailgun->sendMessage($domain, $params);

var_dump($response);

//$message = $mailgun->messages();

//$response = $message->send($domain, $params);
 *
 */


sendThroughMailgun(
	'sMedia Smart Offer Lead<offers@smedia.ca>',
	'sales@campkins.com,roland.goreski@hotmail.com,regan@smedia.ca',
	'#02 Test Lead Subject',
	'Hello,<p>This is test lead message</p>',
	$mailgun_api_key
);

function sendThroughMailgun($from, $to, $subject, $html, $api_key)
{
	$sfrom = rawurlencode($from);
	$sto = rawurlencode($to);
	$ssubject = rawurlencode($subject);
	$shtml = rawurlencode($html);
	$url = "https://api.mailgun.net/v3/mail.smedia.ca/messages";
	$post_data = "from={$sfrom}&to={$sto}&subject={$ssubject}&html={$shtml}";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_USERPWD, "api:$api_key");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_URL, str_replace('~', '%7E', $url));
	curl_setopt(
		$curl,
		CURLOPT_USERAGENT,
		'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:30.0) Gecko/20100101 Firefox/30.0'
	);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

	$contents = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

	var_dump($contents);

	if ($curl) {
		curl_close($curl);
	}

	if ($httpcode > 400) {
		return null;
	}

	if ($contents) {
		return $contents;
	} else {
		return null;
	}
}
