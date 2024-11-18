<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


$smedia_dir = '/var/www/html/tm.smedia.ca';
include_once("{$smedia_dir}/vendor/autoload.php");
include_once("{$smedia_dir}/adwords3/db-config.php");
require_once "{$smedia_dir}/adwords3/config.php";
//include_once("{$smedia_dir}/adwords3/utils.php");


use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;


function s3SaveFile($key, $file_path, $bucket, $s3_config = ["region" => "us-east-1", 'version' => '2006-03-01'])
{

    $s3_client = new S3Client($s3_config);
    $prop = array(
        'Bucket' => $bucket,
        'Key'    => $key,
        'Body'   => file_get_contents($file_path),

    );

    try {
        $result = $s3_client->putObject($prop);
    } catch (S3Exception $e) {
        print_r($e->getMessage());

        return false;
    }

    return $result;
}


/**
 * s3GetUrl - Get pre signed url for s3 object
 *
 * @param mixed $key
 * @param mixed $bucket
 * @param string $time
 * @param array $s3_config
 * @return string | bool
 */
function s3GetUrl($key, $bucket, $time = '+20 minutes', $s3_config = ["region" => "us-east-1", 'version' => '2006-03-01'])
{
    $s3_client = new S3Client($s3_config);

    $prop = array(
        'Bucket' => $bucket,
        'Key'    => $key,
    );

    try {
        $result = $s3_client->getCommand('getObject', $prop);
    } catch (S3Exception $e) {
        print_r($e->getMessage());
        return false;
    }


    $result = $s3_client->createPresignedRequest($result, $time);
    $url = (string) $result->getUri();
    return $url;
}



$r = s3SaveFile('delete-image.jpg', 'delete-image.jpg', 'smedia-user-photos');
var_dump($r);

$r = s3GetUrl('delete-image.jpg', 'smedia-user-photos', '+7 days');

var_dump($r);