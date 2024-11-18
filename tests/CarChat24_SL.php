<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

$base_dir       = dirname(__DIR__) . "/";
$adwords_dir    = $base_dir . "adwords3/";
$carChat24CSV   = $base_dir . 'reports/CarChat24.csv';
$livechatCSV    = $base_dir . 'reports/livechat.csv';
$gubagooCSV     = $base_dir . 'reports/gubagoo.csv';
$foxdealerCSV   = $base_dir . 'reports/foxdealer.csv';
$selenium_dir   = $base_dir . 'reports/selenium_proxy/';
$proxy_dir      = $adwords_dir . 'data/';
$chrome_version = '74.0.3729.6';
//$chrome_version = '77.0.3865.40';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $scrapper_configs;

/* SELENIUM HOST ADDRESS */
//$selenium_host_addr = "http://localhost:4444/wd/hub";
//$selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
$selenium_host_addr = "http://selenium.smedia.ca:4444/wd/hub";

$get_dealer = filter_input(INPUT_GET, 'dealership');

if ($get_dealer) {
    $scraper_config = isset($scrapper_configs) ? $scrapper_configs[$get_dealer] : false;
}

/*if ($scraper_config)
{
$use_proxy  = isset($scraper_config['use-proxy']) ? $scraper_config['use-proxy'] : true;
$proxy_area = isset($scraper_config['proxy_area']) ? $scraper_config['proxy_area'] : false;    // 'FL'  or 'CA'
}*/

$db_connect = new DbConnect('');

if ($get_dealer) {
    $allactive_dealers = $db_connect->get_all_dealers("`dealership` = '$get_dealer'");
} else {
    $allactive_dealers = $db_connect->get_all_dealers("`status` = 'active' OR `status` = 'trial' OR `status` = 'trial-setup'");
}

$outstream = fopen($gubagooCSV, 'a+');
fputcsv($outstream, ['Dealership', 'Website', 'Report']);
$outstream = fopen($carChat24CSV, 'a+');
fputcsv($outstream, ['Dealership', 'Website', 'Report']);
$outstream = fopen($livechatCSV, 'a+');
fputcsv($outstream, ['Dealership', 'Website', 'Report']);
$outstream = fopen($foxdealerCSV, 'a+');
fputcsv($outstream, ['Dealership', 'Website', 'Report']);

$options = new ChromeOptions();

/*if ($scrapper_config && $use_proxy == true)
{*/
/* GET RANDOM PROXY AND SEPARATE INTO PARTS */
$proxy_list = $proxy_dir . 'proxy-list.txt';

/*if ($scrapper_config && $proxy_area)
{
if ($proxy_area === 'FL')
{
$proxy_list = $proxy_dir . 'fl-proxy-list.txt';
}
else if ($proxy_area === 'CA')
{
$proxy_list = $proxy_dir . 'ca-proxy-list.txt';
}
}*/

$rand_proxy = getRandomProxy($proxy_list);
$proxy_part = explode(':', $rand_proxy);
$proxy_host = $proxy_part[0];
$proxy_port = $proxy_part[1];
$proxy_user = $proxy_part[2];
$proxy_pass = $proxy_part[3];
$PROXY      = $proxy_host . ':' . $proxy_port;

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

/* UPLOAD THE EXTENSION */
//$options->addExtensions([$pluginForProxyLogin]);
/*}*/

$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/$chrome_version Safari/537.36";
$arguments = ['--user-agent=' . $userAgent];
$options->addArguments($arguments);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($selenium_host_addr, $caps);

foreach ($allactive_dealers as $dealership => $dealer_data) {
    /* HIT THE DOMAIN URL TWICE TO GET THE SELENIUM SESSION RUNNING */
    /*$driver->get($dealer_data['websites']);
    sleep(2);*/
    try
    {
        seleniumInjector($driver, $dealer_data['websites']);
    } catch (Exception $e) {
        continue;
    }

}

/*if ($use_proxy == true)
{*/
unlink($pluginForProxyLogin);
/*}*/

$driver->quit();

$db_connect->close_connection();

/**
 * { function_description }
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver  The driver
 * @param      string                                      $url     The url
 */
function seleniumInjector(RemoteWebDriver $driver, string $url)
{
    $driver->get($url)->wait(5, 1000)->until(
        function () use ($driver) {
            $title = $driver->getTitle();

            if (strpos($title, 'ERROR') === false) {
                return true;
            } else {
                return false;
            }
        },
        'Error'
    );

    sleep(5);
    injectVisualScraper($driver);
    sleep(3);
}

/**
 * { function_description }
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver  The driver
 */
function injectVisualScraper(RemoteWebDriver $driver)
{
    $script = <<< 'Chokshanada'
            var script_visual_scraper = "https://tm.smedia.ca/tests/CarChat24.js";
            var visualScraperScript = document.createElement('script');
            visualScraperScript.setAttribute('src', script_visual_scraper);
            document.body.appendChild(visualScraperScript);
Chokshanada;

    $driver->executeScript($script);
}
