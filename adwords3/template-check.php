<?php

/**
 * This is to check if template has changed and notify Emil & Arnel
 * on time to re-sync and verify graphics
 */

require_once 'config.php';
require_once 'utils.php';

global $CronConfigs, $scrapper_configs;

$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));
$working_dir = __DIR__ . '/template-check/';
set_time_limit(0);
$changed = [];

foreach ($cron_names as $cron_name) {
    echo "Checking $cron_name" . PHP_EOL;

    $working_file = "{$working_dir}{$cron_name}.hash";
    $current_hash = calculate_template_hash($cron_name);
    $existing_hash = file_exists($working_file) ? file_get_contents($working_file) : null;

    echo "Current has is '{$current_hash}' and it was '{$existing_hash}'" . PHP_EOL;

    if ($current_hash == $existing_hash) {
        continue;
    }

    if (file_exists($working_file)) {
        $changed[] = $cron_name;
        echo "Template for {$cron_name} has changed" . PHP_EOL;
    } else {
        echo "Template hash initializing" . PHP_EOL;
    }

    file_put_contents($working_file, $current_hash);

    $template_dir = __DIR__ . '/templates/' . $cron_name;
    $ntmp_dir     = $working_dir . $cron_name . "/";

    if (!file_exists($ntmp_dir)) {
        mkdir($ntmp_dir);
    }

    $version_dir = $ntmp_dir . $current_hash;

    if (file_exists($template_dir)) {
        echo "Copying $template_dir to $version_dir" . PHP_EOL;
        recurseCopy($template_dir, $version_dir);
    }
}

echo count($changed) . " dealerships has changed template" . PHP_EOL;

if (count($changed) == 0) {
    exit;
}

$send_to = ['tanvir@smedia.ca', 'emmanuel@smedia.ca', 'arnel@smedia.ca'];
$message = "<b>Re-sync & verification Required!</b><br/><br/>Banner template has changed for following dealerships.<br/><ol>";

foreach ($changed as $cron_name) {
    $message .= "<li><a href=\"https://tm.smedia.ca/dynamic-ad-feed.php?view=live&dealership=$cron_name\">$cron_name</a></li>";
}

$message .= '</ol><br/>Please verify banners and re-sync as required';

echo "Email Message:" . PHP_EOL;
echo $message . PHP_EOL;

SendEmail($send_to, ['reports@smedia.ca', 'Template Change Notification'], "Banner Template has Changed", $message);

echo "Email Sent";
