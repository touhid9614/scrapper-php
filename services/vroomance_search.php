<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Remote\RemoteWebDriver;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "$base_dir/adwords3/";
$selenium_dir = $adwords_dir . '/caches/selenium_proxy/';
$proxy_dir    = $adwords_dir . 'data/';
$log_path     = $adwords_dir . "caches/vroomance/simulation.txt";
$multi_log    = $adwords_dir . "caches/vroomance/multisession.txt";
$post_code    = $adwords_dir . "data/regina_post_code.txt";

/* INCLUDE REQUIRED FILES */
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';

/* SELENIUM HOST ADDRESS */
//$selenium_host_addr = "http://localhost:4444/wd/hub";
//$selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
$selenium_host_addr = "http://selenium.smedia.ca:4444/wd/hub";

$php_binary = 'php';
exec("ps aux |  grep -i php | grep vroomance_selenium.php | grep -v grep | awk '{print $2}' | xargs kill");
$worker_list = explode("\n", `ps aux |  grep -i php | grep vroomance_selenium.php | grep -v grep | awk '{print $2, $13, $3, $10, $8}'`);

for ($k = 0; $k < 2; $k++) {
    for ($i = 0; $i < 5; $i++) {
        $file       = $base_dir . '/services/vroomance_selenium.php';
        $launch_str = $php_binary . ' '
        . escapeshellarg($file) . ' '
            . ' > /dev/null 2>/dev/null &';
        $sts = exec($launch_str, $outputr);
    }

    writeLog($log_path, "{$k} : Ten sessions done. \n");
    sleep(300);

    /*killAllSeleniumSessions();
    sleep(30);*/
    //break;
}

/**
 * { function_description }
 */
function killAllSeleniumSessions()
{
    $base_dir    = dirname(__DIR__);
    $adwords_dir = "$base_dir/adwords3/";
    $running     = $adwords_dir . "caches/vroomance/running.txt";

    if (!file_exists($running)) {

        $createFile = fopen($adwords_dir . "caches/vroomance/running.txt", "a+");
        $createFile = fopen($running, "a+");
        fclose($createFile);
        writeLog($log_path, "\nCreated running file.\n");
        return;
    }

    $sessions = json_decode(file_get_contents($running), true);

    if (empty($sessions)) {
        writeLog($log_path, "\nFound empty running file.\n");
        return;
    }

    foreach ($sessions as $key => $value) {
        try
        {
            RemoteWebDriver::createBySessionID($value, $selenium_host_addr)->close();
        } catch (Exception $e) {
            writeLog($log_path, "\n\n\nFailed to delete selenium session {$value}.\n" . $e . "\n\n");
        }

        sleep(1);
    }

    $sessions = [];
    file_put_contents($running, $sessions);
    //fclose($running);

    writeLog($log_path, "\n\n\n\n\nAll existing selenium sessions has been terminated.\n\n\n\n\n");
}
