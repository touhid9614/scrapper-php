<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/adwords3/utils.php';

use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

$bucket_name               = "smedia-config";
$s3_config                 = ["region" => "us-east-1", 'version' => '2006-03-01'];
$s3_client                 = new S3Client($s3_config);
$config_directory          = "config";
$scrapper_config_directory = "scrapper-config";

$target_file = "config/test.php";
$temp_file   = tempnam(sys_get_temp_dir(), 'build-file');

$key = 'config/barbermotors.php';

//try {
//
//    $result = $s3_client->getObject([
//        'Bucket' => $bucket_name,
//        'Key' => $key
//    ]);
//
//    $code = $result['Body'];
//
//    $cleaned_code = trim(str_replace('global $scrapper_configs;', '',
//        str_replace('global $CronConfigs;', '',
/*            str_replace('?>', '',*/
//                str_replace('<?php', '', $code)))));
//
//    print_r($code);
//
//} catch (S3Exception $e) {
//    print_r($e->getMessage());
//}

$hostname = 'test';
try {
    $result = $s3_client->doesObjectExist($bucket_name, $target_file);
    print_r($result);
    if (!$result) {
        $config_file_content = '<?php' . "\n" . 'global $CronConfigs;' . "\n"
            . ' $CronConfigs["' . $hostname . '"] = array( ' . "\n"
            . "\t" . '"name"  =>" ' . $hostname . '",' . "\n"
            . "\t" . '"email" => "regan@smedia.ca",' . "\n"
            . "\t" . '"password" =>" ' . $hostname . '",' . "\n"
            . "\t" . '"no_adv" => true ,' . "\n"
            . ');';

        file_put_contents($temp_file, $config_file_content . "\n\n", FILE_APPEND);
        $current_build_state = hash_file("sha256", $temp_file);
        $uploader            = new MultipartUploader($s3_client, $temp_file, [
            'bucket' => $bucket_name,
            'key'    => $target_file,
        ]);

        try {
            $result  = $uploader->upload();
            $message = "Upload successful config........";
            echo "<script type='text/javascript'>alert('$message');</script>";
            print_r($message);
        } catch (MultipartUploadException $e) {
            $message = "Can't Create File ........" . $e->getMessage();
            echo "<script type='text/javascript'>alert('$message');</script>";
            print_r($message);
        }
    }
} catch (S3Exception $e) {
    $message = "S3 Setting error ........" . $e->getMessage();
    echo "<script type='text/javascript'>alert('$message');</script>";
    print_r($message);
}
exit;

echo '<br><br> Upload file<br>';
$hostname            = 'test';
$config_file_content = '<?php' . "\n" . 'global $CronConfigs;' . "\n"
    . ' $CronConfigs["' . $hostname . '"] = array( ' . "\n"
    . "\t" . '"name"  =>" ' . $hostname . '",' . "\n"
    . "\t" . '"email" => "regan@smedia.ca",' . "\n"
    . "\t" . '"password" =>" ' . $hostname . '",' . "\n"
    . "\t" . '"no_adv" => true ,' . "\n"
    . ');';

file_put_contents($temp_file, $config_file_content . "\n\n", FILE_APPEND);

$current_build_state = hash_file("sha256", $temp_file);

$uploader = new MultipartUploader($s3_client, $temp_file, [
    'bucket' => $bucket_name,
    'key'    => $target_file,
]);

# Perform the upload.
try {
    $result = $uploader->upload();
    echo 'upload successful ';
} catch (MultipartUploadException $e) {
    print_r($e->getMessage());
}

exit;

try {

    $results = $s3_client->getPaginator('ListObjects', [
        'Bucket' => $bucket_name,
        'Prefix' => $config_directory,
    ]);

    $template_tree = [];
    echo '<pre>';
    //    var_dump($results);
    foreach ($results as $result) {
        var_dump($result);
        foreach ($result['Contents'] as $object) {
            var_dump($object);
            $key = $object['Key'];
            if (substr($key, -4) != '.php') {
                echo 'not php file';
                continue;
            }

            $result = $s3_client->getObject([
                'Bucket' => $bucket_name,
                'Key'    => $key,
            ]);

            $code = $result['Body'];
            var_dump($code);
            exit;
        }
    }
} catch (S3Exception $e) {
    printLog($e->getMessage(), true);
}
