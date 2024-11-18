<?php

/* USE FACEBOOK WEBDRIVER */
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

/* SMEDIA DIRECTORY MAPPING */
$base_dir     = dirname(__DIR__);
$adwords_dir  = "{$base_dir}/adwords3/";
$selenium_dir = "{$base_dir}/reports/selenium_proxy/";
$proxy_dir    = "{$adwords_dir}data/";
$log_path     = "{$adwords_dir}caches/VS/selenium_log/log.txt";
//$chrome_version = '79.0.3945.88';
$chrome_version = '79.0.3945.130';
$one_day        = 43200; //12 hours

/* INCLUDE REQUIRED FILES */
require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once $base_dir . '/visual-scraper/regex_generator.php';

global $scrapper_configs;

/* SELENIUM HOST ADDRESS */
$selenium_host_addr = "http://localhost:4444/wd/hub";
//$selenium_host_addr = "http://10.24.11.193:4444/wd/hub";
//$selenium_host_addr = "http://selenium.smedia.ca:4444/wd/hub";

$options   = new ChromeOptions();
$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/$chrome_version Safari/537.36";
$arguments = ['--user-agent=' . $userAgent];
$options->addArguments($arguments);
$caps = DesiredCapabilities::chrome();
$caps->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($selenium_host_addr, $caps);

echo "done";
