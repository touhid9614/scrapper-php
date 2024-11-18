<?php

$adwords_dir = dirname(dirname(__DIR__)) . '/adwords3/';
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'db_connect.php';


die();


$domain 	= 'mail.smedia.ca';
$from 		= 'sMedia Support <support@smedia.ca>';
$subject 	= 'sMedia Password Reset';
$message    =  file_get_contents('welcome_email.html');

$db_connect = new DbConnect('');

$fetch = $db_connect->query("SELECT dealership, email FROM users WHERE account_disabled = 0 AND user_type != 'a'");
$dealers = [];
$outstream = fopen('multiple_email.csv', 'w+');
$onestream = fopen('single_email.csv', 'w+');
fputcsv($outstream, ['email', 'dealership']);
fputcsv($onestream, ['email', 'dealership']);

while ($row = mysqli_fetch_assoc($fetch))
{
	/*$to = $row['email'];

	if ($to)
	{
		echo $to . '<br>';
		SendEmail($to, $from, $subject, $message);
	}*/

	if ($row['dealership'] && $row['dealership'] != '')
	{
		$dealers[$row['email']][] = $row['dealership'];
	}
}

foreach ($dealers as $key => $value) 
{
	if (count($value) == 1)
	{
		fputcsv($onestream, [$key, $value[0]]);
		unset($dealers[$key]);
	}
}

//echo count($dealers); exit;


file_put_contents('multiple_email.txt', print_r($dealers, true));



foreach ($dealers as $email => $dealer_array) 
{
	fputcsv($outstream, [$email, $dealer_array[0]]);
	$tmp = true;

	foreach ($dealer_array as $key => $value) 
	{
		if ($tmp)
		{
			$tmp = false;
			continue;
		}

		fputcsv($outstream, ['', $value]);
	}

    fputcsv($outstream, ['', '']);
}