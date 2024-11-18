<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "{$base_dir}/adwords3";
$selenium_dir = "{$adwords_dir}/caches/selenium_proxy";
$proxy_dir    = "{$adwords_dir}/data";
$log_file     = "{$adwords_dir}/caches/trader.log";

/* INCLUDE REQUIRED FILES */
require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

$mode = 'LOCAL';
// $mode = 'DEVELOPMENT';
// $mode = 'PRODUCTION';

if ($mode == 'LOCAL') {
    $chrome_version     = '98.0.4758.102';
    $selenium_host_addr = "http://localhost:4444/wd/hub";
} else if ($mode == 'PRODUCTION') {
    $chrome_version     = '74.0.3729.6';
    $selenium_host_addr = "https://selenium.smedia.ca/wd/hub";
} else if ($mode == 'DEVELOPMENT') {
    $chrome_version     = '74.0.3729.6';
    $selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
}

$options   = new ChromeOptions();
$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/{$chrome_version} Safari/537.36";
$arguments = ['--user-agent=' . $userAgent];
$options->addArguments($arguments);
$options->addArguments(['--disable-blink-features=AutomationControlled']);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($selenium_host_addr, $caps);

$root_domain = "https://www.rvtrader.com/Alabama/rv-dealers/results?state=Alabama%7CAL";

/* HIT THE DOMAIN URL TWICE TO GET THE SELENIUM SESSION RUNNING */
sleep(1);

try {
    seleniumGet($driver, $root_domain);
    sleep(10);
    // seleniumGet($driver, $root_domain);
} catch (Exception $e) {
    $msg = 'SITE:' . $root_domain . '<br> ERROR MESSAGE: ' . $e;
    echo "ERROR REPORT:<br>{$msg}";
}

sleep(3);


function seleniumGet(RemoteWebDriver $driver, string $url)
{
    $driver->get($url)->wait(10, 1000)->until(
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
}
