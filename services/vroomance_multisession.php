<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "$base_dir/adwords3/";
$selenium_dir = $adwords_dir . '/caches/selenium_proxy/';
$proxy_dir    = $adwords_dir . 'data/';
$log_path     = $adwords_dir . "caches/vroomance/simulation.txt";

/* INCLUDE REQUIRED FILES */
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'utils.php';

/* ARRAY_PUSH FUNCTION TAKE A LOT OF MEMMORY. PHP MAY HAVE MEMORY LEAK. */
ini_set('memory_limit', '4096M');

/* SELENIUM HOST ADDRESS */
$selenium_host_addr = "http://localhost:4444/wd/hub";
//$selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
//$selenium_host_addr = "http://selenium.smedia.ca:4444/wd/hub";

/* GET THE URL PARAMETERS */
//$proxy_area = filter_input(INPUT_GET, 'proxy_area');    // 'FL'  or 'CA'
//$srpURL     = urldecode(filter_input(INPUT_GET, 'currURL'));

/* CHECK FOR ARRAY OF ARGUMENTS PASSED TO SCRIPT */
if (isset($argv)) {
    writeLog($log_path, "Write argv " . $argv[0]);
    $get_dealer = urldecode($argv[0]);
}

/* GET RANDOM PROXY AND SEPARATE INTO PARTS */
$proxy_list = $proxy_dir . 'proxy-list.txt';

if ($proxy_area === 'FL') {
    $proxy_list = $proxy_dir . 'fl-proxy-list.txt';
} else if ($proxy_area === 'CA') {
    $proxy_list = $proxy_dir . 'ca-proxy-list.txt';
}

$rand_proxy = getRandomProxy($proxy_list);
$proxy_part = explode(':', $rand_proxy);
$proxy_host = $proxy_part[0];
$proxy_port = $proxy_part[1];
$proxy_user = $proxy_part[2];
$proxy_pass = $proxy_part[3];
$PROXY      = $proxy_host . ':' . $proxy_port;
writeLog($log_path, "Chosen proxy : {$rand_proxy} for {$srpURL}");

/* CREATE CHROME EXTENSION FOR PROXY AUTHENTICATION */
$pluginForProxyLogin = $selenium_dir . 'selenium_proxy.zip';
$zip                 = new ZipArchive();
$res                 = $zip->open($pluginForProxyLogin, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zip->addFile($selenium_dir . 'manifest.json', 'manifest.json');
$background = file_get_contents($selenium_dir . 'background.js');
$background = str_replace(['%proxy_host', '%proxy_port', '%proxy_user', '%proxy_pass'], [$proxy_host, intval($proxy_port), $proxy_user, $proxy_pass], $background);
$zip->addFromString('background.js', $background);
$popup = file_get_contents($selenium_dir . 'popup.html');
$popup = str_replace('192.168.0.1', $PROXY, $popup);
$zip->addFromString('popup.html', $popup);
$zip->addFile($selenium_dir . 'popup.js', 'popup.js');
$zip->addFile($selenium_dir . 'icon.png', 'icon.png');
$zip->close();

/* SET SELENIUM SESSION AND ADD CHROME EXTENSION */
$options = new ChromeOptions();
$options->addExtensions([$pluginForProxyLogin]);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($selenium_host_addr, $caps);

/* HIT DOMAIN URL TWICE TO START SELENIUM SESSION RUNNING */
$driver->get($srpURL);
sleep(2);
$driver->get($srpURL);

/* VISIT THE VEHICLES NOW */
/* VROOMANCE SEARCH RESULT SRP */
$srps = $driver->findElements(WebDriverBy::className('result-item-name'));

foreach ($srps as $srp) {
    $srp->click();
    sleep(1);
}

/* SCROLL TO BOTTOM OF PAGE AND RETURN BACK TO TOP AND SLEEP AND EXIT */
$driver->executeScript('window.scrollTo(0, document.body.scrollHeight);');
sleep(mt_rand(2, 5));
$driver->executeScript('window.scrollTo(document.body.scrollHeight, 0);');
sleep(mt_rand(10, 30));
$driver->quit();
