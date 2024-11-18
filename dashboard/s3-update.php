<?php

$base_dir = dirname(__DIR__);
require_once $base_dir . '/vendor/autoload.php';
require_once $base_dir . '/adwords3/utils.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;

$error_dir = $base_dir . '/adwords3/caches/s3/';

function s3Update($config, $cron_name, $scrapper = false)
{
	$error_file  = $error_dir . $cron_name . '.log';
	$bucket_name = "smedia-config";
	$s3_config	 = ["region" => "us-east-1", 'version' => '2006-03-01'];
	$s3_client   = new S3Client($s3_config);

	if ($scrapper) {
		$config_key = "scrapper-config/{$cron_name}.php";
	} else {
		$config_key = "config/{$cron_name}.php";
	}

	$temp_file = tempnam(sys_get_temp_dir(), 'temp-config');

	file_put_contents($temp_file, $config);

	$uploader = new MultipartUploader($s3_client, $temp_file, [
		'bucket' => $bucket_name,
		'key' => $config_key
	]);

	try {
		$result = $uploader->upload();
		file_put_contents($error_file, var_export($result, true), FILE_APPEND);
	} catch (MultipartUploadException $e) {
		echo 'Error in Upload in s3';
		print_r($e->getMessage());
		file_put_contents($error_file, "Error in Upload in s3.\n". var_export($e->getMessage(), true) . "\n\n", FILE_APPEND);
	}
}

function configsUpdate($config, $cron_name, $scrapper = false)
{
	$all_config_file = dirname(__DIR__) . '/adwords3/caches/configs.php';

	if ($scrapper) {
		file_put_contents($all_config_file, '$scrapper_configs["' . $cron_name . '"] = ' . var_export($config, true) . ";\n\n", FILE_APPEND);
	} else {
		file_put_contents($all_config_file, '$CronConfigs["' . $cron_name . '"] = ' . var_export($config, true) . ";\n\n", FILE_APPEND);
	}
}

function s3DealerConfig($cron_name, $scrapper = false)
{
	$bucket_name = "smedia-config";
	$s3_config   = ["region" => "us-east-1", 'version' => '2006-03-01'];
	$s3_client   = new S3Client($s3_config);
	$key         = ($scrapper == true ? "scrapper-" : '') . "config/{$cron_name}.php";

	try {
		$result = $s3_client->getObject([
			'Bucket' => $bucket_name,
			'Key' => $key
		]);

		$code = $result['Body'];
	} catch (S3Exception $e) {
		$code = '';
		echo $e->getMessage();
	} catch (Exception $e) {
		$code = '';
		echo $e->getMessage();
	}

	$cleaned_code = trim($code);

	return  $cleaned_code;
}
