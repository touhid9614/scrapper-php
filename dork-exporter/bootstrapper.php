<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set("memory_limit", "2048M");

#special scrappers
if (!defined('ABSPATH')) {
    define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');
}

if (!defined('SCRPINC')) {
    define('SCRPINC', ABSPATH . 'special-configs/');
}

if (!defined('ADSYNCPATH')) {
    define('ADSYNCPATH', dirname(ABSPATH) . '/adwords3');
}

require_once 'config.php';
require_once 'includes/user-agents.php';
require_once ADSYNCPATH . '/config.php';
require_once ADSYNCPATH . '/Google/Util.php';
require_once ADSYNCPATH . '/utils.php';
require_once ADSYNCPATH . '/scrapper.php';
require_once ADSYNCPATH . '/carlist-loader.php';

global $customer_id, $account_key, $bing_endpoint, $cache_directory, $cache_directory,
    $proxies, $usages_file, $site_rules, $site_scrappers, $argv, $locality_file,
    $makes_file, $dork_file, $autod_file, $query_directory;

$bing_endpoint = "https://{$customer_id}:{$account_key}@api.datamarket.azure.com/Bing/Search/v1/Web";

#Caching
$cache_directory = __DIR__ . '/web-cache';

if (!file_exists($cache_directory) || !is_dir($cache_directory)) {
    mkdir($cache_directory);
}

#Rules
$site_rules         = [];
$rules_directory    = __DIR__ . '/rules';

if (is_dir($rules_directory)) {
    foreach (array_filter(glob($rules_directory . '/*.php'), 'is_file') as $file) {
        require_once $file;
    }
}

#Scrappers
$site_scrappers         = [];
$scrappers_directory    = __DIR__ . '/scrappers';

if (is_dir($scrappers_directory)) {
    foreach (array_filter(glob($scrappers_directory . '/*.php'), 'is_file') as $file) {
        require_once $file;
    }
}

require_once 'includes/simple_html_dom.php';
require_once 'includes/functions.php';

#Usages
$usages_file    = "{$cache_directory}/ip-usages.obj";

#Proxies
$proxies        = load_proxies();

#Data files
$locality_file  = __DIR__ . '/data/cities.txt';
$makes_file     = __DIR__ . '/data/makes.txt';
$dork_file      = __DIR__ . '/data/dork.txt';
$autod_file     = __DIR__ . '/data/auto_dealers.txt';

#query directory
$query_directory = __DIR__ . '/queries';

require_once 'includes/query_builder.php';
require_once 'includes/bing.php';
require_once 'includes/google.php';
require_once ADSYNCPATH . '/db_connect.php';
require_once 'includes/geocoding.php';
require_once 'includes/reqproc.php';

require_once 'includes/scrapper-loader.php';
require_once 'includes/scrapjack.php';
require_once 'includes/autotrader.php';
require_once 'includes/car-scrapper.php';