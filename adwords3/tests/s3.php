<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use Aws\S3\S3Client;

$bucket = 'smedia-banners';

$file_path = '../templates/carlylegm/popup-bg.png';

$client = S3Client::factory([
    'region'  => 'us-east-1', 
    'version' => '2006-03-01'
]);

$result = $client->putObject(array(
    'Bucket' => $bucket,
    'Key'    => 'test-im age.png',
    'Body'   => file_get_contents($file_path)
));

var_dump($result);

$result2 = $client->deleteObject([
    'Bucket' => $bucket,
    'Key'    => 'data.txt'
]);

var_dump($result2);

$client = S3Client::factory();

$result = $client->putObject(array(
    'Bucket' => $bucket,
    'Key'    => 'data.txt',
    'Body'   => 'Hello!'
));

var_dump($result);
