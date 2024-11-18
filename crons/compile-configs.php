<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/adwords3/utils.php';

use Aws\Common\Exception\MultipartUploadException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

global $all_errors;

/**
 * Determines whether the specified code is valid php.
 *
 * @param      <type>   $code   The code
 *
 * @return     boolean  True if the specified code is valid php, False otherwise.
 */
function isValidPHP($code)
{
    global $temp_check_file;

    if (!$temp_check_file) {
        $temp_check_file = tempnam(sys_get_temp_dir(), 'syntex-check');
    }

    file_put_contents($temp_check_file, $code);

    return isValidPHPFile($temp_check_file);
}

/**
 * Prints a log.
 *
 * @param      <type>   $msg    The message
 * @param      boolean  $error  The error
 */
function printLog($msg, $error = false)
{
    global $all_errors, $log_file;

    if ($log_file) {
        file_put_contents($log_file, $msg . PHP_EOL, FILE_APPEND);
    }

    if ($error) {
        echo "ERROR: " . $msg;
        $all_errors[] = $msg;
    }

    echo $msg . PHP_EOL;
}

/**
 * Determines whether the specified file is valid php file.
 *
 * @param      <type>   $file   The file
 *
 * @return     boolean  True if the specified file is valid php file, False otherwise.
 */
function isValidPHPFile($file)
{
    return stripos(getErrorMsg($file), "No syntax errors detected") === 0;
}

/**
 * Gets the error message.
 *
 * @param      <type>  $file   The file
 *
 * @return     <type>  The error message.
 */
function getErrorMsg($file)
{
    return shell_exec("php -l " . escapeshellarg($file));
}

/**
 * { function_description }
 *
 * @param      \Aws\S3\S3Client  $s3_client    The s 3 client
 * @param      <type>            $bucket_name  The bucket name
 * @param      <type>            $key          The key
 * @param      <type>            $temp_file    The temporary file
 */
function processFile(S3Client $s3_client, $bucket_name, $key, $temp_file)
{
    if (substr($key, -4) != '.php') {
        printLog("Ignoring file.==> $key  <br>");
        return;
    }

    printLog("Processing file ==> {$key} <br>");

    try {
        $result = $s3_client->getObject([
            'Bucket' => $bucket_name,
            'Key'    => $key,
        ]);

        $code = $result['Body'];

        if (isValidPHP($code)) {
            $cleaned_code = trim(str_replace('global $scrapper_configs;', '',
                str_replace('global $scrapper_configs, $nlp_api;', '',
                    str_replace('global $CronConfigs;', '',
                        str_replace('<?php', '', $code)))));

            if (substr($cleaned_code, -2) == '?>') {
                $cleaned_code = trim(substr($cleaned_code, 0, strlen($cleaned_code) - 2));
            }

            file_put_contents($temp_file, $cleaned_code . "\n\n", FILE_APPEND);
        } else {
            $f_err = getErrorMsg($code);
            printLog("File contains syntax error {$key}\n\n{$f_err} <br>", true);
        }
    } catch (S3Exception $e) {
        printLog($e->getMessage(), true);
    }
}

/**
 * { function_description }
 *
 * @param      \Aws\S3\S3Client  $s3_client    The s3 client
 * @param      <type>            $bucket_name  The bucket name
 * @param      <type>            $directory    The directory
 * @param      <type>            $temp_file    The temporary file
 */
function process_directory(S3Client $s3_client, $bucket_name, $directory, $temp_file)
{
    try {
        $results = $s3_client->getPaginator('ListObjects', [
            'Bucket' => $bucket_name,
            'Prefix' => $directory,
        ]);

        foreach ($results as $result) {
            foreach ($result['Contents'] as $object) {
                processFile($s3_client, $bucket_name, $object['Key'], $temp_file);
            }
        }
    } catch (S3Exception $e) {
        printLog($e->getMessage(), true);
    }
}

/**
 * Gets the build state.
 *
 * @param      \Aws\S3\S3Client  $s3_client    The s 3 client
 * @param      <type>            $bucket_name  The bucket name
 * @param      <type>            $states_file  The states file
 *
 * @return     \Aws\S3\S3Client  The build state.
 */
function getBuildState(S3Client $s3_client, $bucket_name, $states_file)
{
    try {
        $result = $s3_client->getObject([
            'Bucket' => $bucket_name,
            'Key'    => $states_file,
        ]);

        return $result['Body'];
    } catch (S3Exception $e) {
        printLog($e->getMessage(), true);
        return null;
    }
}

/**
 * { function_description }
 *
 * @param      \Aws\S3\S3Client  $s3_client    The s 3 client
 * @param      <type>            $bucket_name  The bucket name
 * @param      <type>            $states_file  The states file
 * @param      <type>            $state        The state
 */
function updateBuildState(S3Client $s3_client, $bucket_name, $states_file, $state)
{
    try {
        $result = $s3_client->putObject([
            'Bucket' => $bucket_name,
            'Key'    => $states_file,
            'Body'   => $state,
        ]);
    } catch (S3Exception $e) {
        printLog($e->getMessage(), true);
    }
}

/**
 * { function_description }
 *
 * @param      \Aws\S3\S3Client  $s3_client                  The s 3 client
 * @param      <type>            $bucket_name                The bucket name
 * @param      <type>            $config_directory           The configuration directory
 * @param      <type>            $scrapper_config_directory  The scrapper configuration directory
 * @param      <type>            $target_file                The target file
 * @param      <type>            $temp_target_file           The temporary target file
 * @param      <type>            $temp_file                  The temporary file
 * @param      <type>            $states_file                The states file
 * @param      <type>            $local_file                 The local file
 */
function compile_configs(S3Client $s3_client, $bucket_name, $config_directory, $scrapper_config_directory, $target_file, $temp_target_file, $temp_file, $states_file, $local_file)
{
    file_put_contents($temp_file, "<?php\n\nglobal \$CronConfigs, \$scrapper_configs, \$nlp_api;\n\n");
    process_directory($s3_client, $bucket_name, $config_directory, $temp_file);
    process_directory($s3_client, $bucket_name, $scrapper_config_directory, $temp_file);

    // All are processed, now check the build file and move it to S3
    if (isValidPHPFile($temp_file)) {
        $current_build_state = hash_file("sha256", $temp_file);
        $last_build_state    = getBuildState($s3_client, $bucket_name, $states_file);

        printLog("Last Build State: " . $last_build_state . " <br>");
        printLog("Current Build State: " . $current_build_state . " <br>");

        if ($current_build_state != $last_build_state) {
            # Prepare the upload parameters.
            $uploader = new MultipartUploader($s3_client, $temp_file, [
                'bucket' => $bucket_name,
                'key'    => $target_file,
            ]);

            // Perform the upload.
            try {
                $result = $uploader->upload();
                printLog("Upload complete: {$result['Key']} <br>");
                copy($target_file, $local_file);
                printLog("Copied to local server: {$local_file} <br>");
            } catch (MultipartUploadException $e) {
                printLog($e->getMessage(), true);
            }

            updateBuildState($s3_client, $bucket_name, $states_file, $current_build_state);
        } else {
            printLog("Build state did not change. Ignoring current build. <br>");
        }
    } else {
        $c_err = getErrorMsg($temp_file);
        printLog("Build file contains error, please check {$temp_file} for more information. Here's syntax check message for combined file:   {$c_err} <br>", true);
        // Prepare the upload parameters.
        $uploader = new MultipartUploader(  $s3_client,  $temp_file, [
            'bucket' => $bucket_name,
            'key'    => $temp_target_file,
        ]);

        // Perform the upload.
        try {
            $result = $uploader->upload();
            printLog("Uploaded file with error: {$result['Key']} <br>");
        } catch (MultipartUploadException $e) {
            printLog($e->getMessage(), true);
        }
    }
}

// General configurations
$bucket_name               = "smedia-config";
$s3_config                 = ["region" => "us-east-1", 'version' => '2006-03-01'];
$s3_client                 = new S3Client($s3_config);
$config_directory          = "config";
$scrapper_config_directory = "scrapper-config";
$target_file               = "build/configs.php";
$temp_target_file          = "build/last-failed-configs.php";
$states_file               = "build/build-state.txt";
$temp_file                 = tempnam(sys_get_temp_dir(), 'build-file');
$all_errors                = [];
$log_file                  = dirname(__DIR__) . '/adwords3/ng_logs/config_build.log';
$local_file                = dirname(__DIR__) . '/adwords3/caches/configs.php';
$this_file                 = 'https://tm.smedia.ca/crons/compile-configs.php';

// Reset log file
file_put_contents($log_file, '');
printLog('=============================================================');
printLog(date('Y-m-d_H:i:s'));
printLog('=============================================================<br>');

$ses_config = [
    'version' => '2010-12-01',
    'region'  => 'us-east-1',
    'key'     => 'AKIAJK2PQ2QGV5X6XHHA',
    'pass'    => 'Ah+d+/iH4Y/AmmtlLgumhzNunhAQn5EnfXFokLLYJo4D',
];

$mail_reciepents = [
    'zaber.mahbub@smedia.ca', 'tanvir@smedia.ca',  'toufiq@smedia.ca', 'touhid@smedia.ca', 'missy@smedia.ca', 'rezwana@smedia.ca',
];

$from    = 'report@smedia.ca';
$subject = 'Configuration build report!';

// Check if already running
$grepstring = 'ps aux  | grep -v sh | grep -v grep | grep ' . escapeshellarg('compile-configs.php');
printLog(`$grepstring`);

if (`$grepstring | wc -l` > 1) {
    printLog("Already running, quitting.");
    die();
}

// Run it
compile_configs($s3_client, $bucket_name, $config_directory, $scrapper_config_directory, $target_file, $temp_target_file, $temp_file, $states_file, $local_file);

// Finaly I can email all errors
if ($all_errors) {
    $message = implode('<br>', $all_errors);
    $message .= "<br>Fix the errors and then you can build again by clicking the following url <br>{$this_file}<br>Or you can wait a few minutes, it will build automatically.";
    SendEmail($mail_reciepents, $from, $subject, $message);
}