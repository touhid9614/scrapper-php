<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

function sync_config(S3Client $s3_client, $bucket_name, $key, $local_file)
{
    try {
        # Get the object.
        $result = $s3_client->getObject([
            'Bucket' => $bucket_name,
            'Key'    => $key,
        ]);

        file_put_contents($local_file, $result['Body']);
    } catch (S3Exception $e) {
        echo $e->getMessage() . PHP_EOL;
    }
}

# General configurations
$bucket_name = "smedia-config";
$s3_config   = ["region" => "us-east-1", 'version' => '2006-03-01'];
$s3_client   = new S3Client($s3_config);
$target_file = "build/configs.php";
$local_file  = dirname(__DIR__) . '/adwords3/caches/configs.php';

sync_config($s3_client, $bucket_name, $target_file, $local_file);