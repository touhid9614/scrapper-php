<?php

    require_once 'config.php';
    require_once 'includes/loader.php';
    require_once 'includes/crm-defaults.php';

    session_start();

    require_once ADSYNCPATH . 'config.php';
    require_once ADSYNCPATH . 'Google/Util.php';
    require_once ADSYNCPATH . 'utils.php';
    require_once ADSYNCPATH . 'db_connect.php';

    require_once dirname(__DIR__) . '/vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    use Aws\Common\Exception\MultipartUploadException;
    use Aws\S3\MultipartUploader;

    $bucket_name = "smedia-config";
    $s3_config = ["region" => "us-east-1", 'version' => '2006-03-01'];
    $s3_client = new S3Client($s3_config);

    $dealership = filter_input(INPUT_POST, 'dealership');
    $status = filter_input(INPUT_POST, 'status');

    //Active or status change of  dealership if exist 
    if (!empty($dealership) && !empty($status)) 
    {
        DbConnect::get_instance()->query("UPDATE dealerships SET  `status` = '$status' WHERE dealership='$dealership'");
        
        /*
         * Log added start
         */
        DbConnect::store_log($user_id, $user['type'], 'Dealer status change', 'Dealer status changet where Dealer name- ' . $dealership . ' and status- ' . $status , $dealership );
        /*
         * Log added end
         */
        /*
         * s3 code
         */
        $key = "config/$dealership.php";
        $targetKeyname=$key.'.cancelled';

        $s3_client->copyObject(array(
            'Bucket'     => $bucket_name,
            'Key'        => $key,
            'CopySource' => "{$bucket_name}/{$targetKeyname}",
        ));

        $result = $s3_client->deleteObject([
            'Bucket' => $bucket_name,
            'Key' => $targetKeyname
        ]);


        /*
         * Old code
         */
        /*
        $file = get_config_path($dealership, CONFIG_TYPE_CANCELLED);

        if ($file)
        {
            $basename = basename($file, ".php.cancelled");
            $new_name = "$config_directory/$basename" . ".php";
            rename($file, $new_name);
            echo 'dealership status changed';
        }
        else
        {
            echo 'config folder not found';
        }
        */
    } 
    else 
    {
        echo 'not a valid request';
    }