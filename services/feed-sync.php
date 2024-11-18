<?php

$temp_dir    = dirname(__DIR__) . '/temp/';
$adwords_dir = dirname(__DIR__) . "/adwords3/";

require_once $adwords_dir . 'utils.php';

if (!file_exists($temp_dir)) {
    if (!mkdir($temp_dir)) {
        die('Unable to create temp directory');
    }
}

$worker_log_dir = $adwords_dir . 'ng_logs/_feed_sync_logs/';

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$feed_log_file = $worker_log_dir . '_general.log';

function feedLog($message)
{
    global $feed_log_file;
    file_put_contents($feed_log_file, $message . "\n" . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
}

$sync_configs = array(
    'autotrader' => array(
        'url'      => 'http://villagerv.ca/export/autotrader.csv',
        'name'     => 'CAGI_SMedia.csv',
        'ftp_host' => 'ftp1.buysell.com',
        'ftp_user' => 'CAGI_SMedia',
        'ftp_pass' => 'Sm1#$%7U',
    ),
    'kijiji'     => array(
        'url'      => 'http://villagerv.ca/export/kijiji.csv',
        'name'     => 'Kijiji.csv',
        'ftp_host' => 'ftp.cargigi.com',
        'ftp_user' => 'kit_villagerv',
        'ftp_pass' => 'kitv1lcats$h4zYi',
    ),
);

feedLog("Starting feed sync at " . date(DATE_COOKIE));

foreach ($sync_configs as $sync_name => $sync_config) {
    $feed_log_file = $worker_log_dir . "$sync_name.log";
    $url           = $sync_config['url'];
    $temp_file     = $temp_dir . $sync_config['name'];
    $remote_file   = $sync_config['name'];
    $ftp_server    = $sync_config['ftp_host'];
    $ftp_user_name = $sync_config['ftp_user'];
    $ftp_user_pass = $sync_config['ftp_pass'];

    $content = HttpGet($url);

    if (!$content) {
        feedLog("Unable to get content from $url at " . date(DATE_COOKIE));
        die();
    }

    file_put_contents($temp_file, $content);

    // set up basic connection
    $conn_id = ftp_connect($ftp_server);

    // login with username and password
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    // upload a file
    if (ftp_put($conn_id, $remote_file, $temp_file, FTP_ASCII)) {
        feedLog("Successfully uploaded $temp_file at " . date(DATE_COOKIE));
    } else {
        feedLog("There was a problem while uploading $temp_file at " . date(DATE_COOKIE));
    }

    // close the connection
    ftp_close($conn_id);
}
