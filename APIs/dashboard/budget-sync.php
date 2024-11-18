<?php
$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';
require_once $base_path . '/adwords3/config.php';
require_once ADSYNCPATH . 'db_connect.php';

header("Access-Control-Allow-Origin: *");

global $CronConfigs;

if (isset($_GET['dealership']) && !isset($CronConfigs[$_GET['dealership']])) {
  die("Wrong dealership");
}

$no_sync =  isset($_GET['no_sync']) && $_GET['no_sync'] == "1";

$cronConfigs = isset($CronConfigs[$_GET['dealership']]) ? [$_GET['dealership'] => $CronConfigs[$_GET['dealership']]] : $CronConfigs;
$budgets = array_filter(array_map(function ($v) {
  return $v['cost_distribution'];
}, $cronConfigs));
$output = [];
foreach ($budgets as $cron_name => $budget) {
  $other = null;
  $new = null;
  $used = null;
  if (isset($budget['adwords'])) {
    $other = $budget['adwords'];
  }
  if (isset($budget['new'])) {
    $new = $budget['new'];
  }
  if (isset($budget['used'])) {
    $used = $budget['used'];
  }
  array_push($output, ["cronName" => $cron_name, "other" => $other, "new" => $new, "used" => $used]);
  if (!$no_sync) {
    file_get_contents("https://api.smedia.ca/v1/ads/ad-budget/{$cron_name}?other={$other}&new={$new}&used={$used}");
  }
}

echo json_encode($output);
