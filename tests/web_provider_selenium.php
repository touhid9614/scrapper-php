<?php

/* USE FACEBOOK WEBDRIVER */

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/* SMEDIA DIRECTORY MAPPING */

$base_dir       = dirname(__DIR__);
$adwords_dir    = "{$base_dir}/adwords3";
$selenium_dir   = "{$adwords_dir}/caches/selenium_proxy";
$proxy_dir      = "{$adwords_dir}/data";
$chrome_version = '83.0.4103.39';
// $chrome_version     = '74.0.3729.6';

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

global $scrapper_configs;

/* SELENIUM HOST ADDRESS */
$selenium_host_addr = "http://localhost:4444/wd/hub";
// $selenium_host_addr = "https://selenium.smedia.ca/wd/hub";

$limit  = isset($_GET['limit']) ? filter_input(INPUT_GET, 'limit') : false;
$offset = isset($_GET['offset']) ? filter_input(INPUT_GET, 'offset') : false;

$db_connect        = new DbConnect('');
$existing          = [];
$marketcheck_table = "marketcheck_dealers_v2";
$query             = "SELECT dealer_id, inventory_url FROM $marketcheck_table WHERE (website_provider = 'SITE_UNREPONSIVE') ORDER BY dealer_id ASC;";

$result = $db_connect->query($query);

while ($row = mysqli_fetch_assoc($result)) {
    $existing[$row['dealer_id']] = $row['inventory_url'];
}

$options    = new ChromeOptions();
$proxy_list = $proxy_dir . 'proxy-list.txt';
$rand_proxy = getRandomProxy($proxy_list);
$proxy_part = explode(':', $rand_proxy);
$proxy_host = $proxy_part[0];
$proxy_port = $proxy_part[1];
$proxy_user = $proxy_part[2];
$proxy_pass = $proxy_part[3];
$PROXY      = $proxy_host . ':' . $proxy_port;

// CREATE CHROME EXTENSION FOR PROXY AUTHENTICATION
$pluginForProxyLogin = $selenium_dir . 'selenium_proxy.zip';
$zip                 = new ZipArchive();
$res                 = $zip->open($pluginForProxyLogin, ZipArchive::CREATE | ZipArchive::OVERWRITE);
$zip->addFile($selenium_dir . 'manifest.json', 'manifest.json');
$background = file_get_contents($selenium_dir . 'background.js');
$background = str_replace(['%proxy_host', '%proxy_port', '%proxy_user', '%proxy_pass'], [$proxy_host, intval($proxy_port), $proxy_user, $proxy_pass], $background);
$zip->addFromString('background.js', $background);
$popup = file_get_contents($selenium_dir . 'popup.html');
$popup = str_replace('192.168.0.1:1212', $PROXY, $popup);
$zip->addFromString('popup.html', $popup);
$zip->addFile($selenium_dir . 'popup.js', 'popup.js');
$zip->addFile($selenium_dir . 'icon.png', 'icon.png');
$zip->close();

// UPLOAD THE EXTENSION
$options->addExtensions([$pluginForProxyLogin]);

$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/$chrome_version Safari/537.36";
$arguments = ['--user-agent=' . $userAgent];
$options->addArguments($arguments);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($selenium_host_addr, $caps);

foreach ($allactive_dealers as $dealership => $dealer_data) {
    try
    {
        foreach ($dealer_data['urls'] as $cur_url) {
            seleniumInjector($driver, $cur_url);
        }
    } catch (Exception $e) {
        continue;
    }
}

unlink($pluginForProxyLogin);

$driver->quit();

$db_connect->close_connection();

/**
 * { function_description }
 *
 * @param \Facebook\WebDriver\Remote\RemoteWebDriver $driver The driver
 * @param string $url The url
 * @throws \Facebook\WebDriver\Exception\NoSuchElementException
 * @throws \Facebook\WebDriver\Exception\TimeOutException
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

    sleep(3);
    injectVisualScraper($driver);
    sleep(1);
}

/**
 * { function_description }
 *
 * @param      \Facebook\WebDriver\Remote\RemoteWebDriver  $driver  The driver
 */
function injectVisualScraper(RemoteWebDriver $driver)
{
    $script = <<< 'Chokshanada'
            var script_visual_scraper = "https://tm.smedia.ca/tests/web_provider.js";
            var visualScraperScript = document.createElement('script');
            visualScraperScript.setAttribute('src', script_visual_scraper);
            document.body.appendChild(visualScraperScript);
Chokshanada;

    $driver->executeScript($script);
}
