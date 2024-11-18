<?php

require_once dirname(__DIR__) . '/dashboard/budgetchecker/config.php';
require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

global $CronConfigs;

$config_dealers  = [];
$db_scraper_list = [];

foreach ($CronConfigs as $cron_name => $cron_config) {
    $config_dealers[] = $cron_name;
}

$scraper_list_query = DbConnect::get_instance()->query("SELECT dealership FROM scraper_list;");
while ($row = mysqli_fetch_assoc($scraper_list_query)) {
    $db_scraper_list[] = $row['dealership'];
}

// Add this new scraper list into scraper_list table
$new_scraper_list = array_diff($config_dealers, $db_scraper_list);
foreach ($new_scraper_list as $key => $dealer) {
    $domain = getDealerDomain($dealer);
    DbConnect::get_instance()->query("INSERT INTO scraper_list (dealership, domain, enable) VALUES ('$dealer', '$domain', 1);");
}

array_walk($config_dealers, function (&$value, &$key) {
    $value = str_replace($value, "'$value'", $value);
});

$active_dealer = implode(',', $config_dealers);
DbConnect::get_instance()->query("UPDATE scraper_list SET enable = 0 WHERE dealership NOT IN ({$active_dealer});");