<?php

$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';

$db_connect = new DbConnect('');
$all_dealer = $db_connect->get_all_dealers();

foreach ($all_dealer as $cron => $details) {
    $executionStartTime = microtime(true);
    $scrapper_table     = "{$cron}_scrapped_data";
    $engaged_data       = [];

    $engaged_query = "SELECT SUM(engaged_vdp.count) AS engaged, vdp_url FROM engaged_vdp WHERE dealership = '{$cron}' GROUP BY vdp_url";
    $engaged_info  = $db_connect->query($engaged_query);

    while ($record = mysqli_fetch_assoc($engaged_info)) {
        $engaged_data[$record['vdp_url']] = $record['engaged'];
    }

    $query = "SELECT svin, url FROM {$scrapper_table} where deleted = false;";
    $car   = $db_connect->query($query);

    while ($record = mysqli_fetch_assoc($car)) {
        $url  = $record['url'];
        $svin = $record['svin'];

        if (array_key_exists($url, $engaged_data)) {
            $engaged = $engaged_data[$url];
            $query   = "UPDATE {$scrapper_table} SET engaged = '{$engaged}' WHERE svin = '{$svin}';";
            $db_connect->query($query);
        }
    }

    $executionEndTime = microtime(true);
    $seconds          = $executionEndTime - $executionStartTime;
}