<?php

exit();

# Filters are turned off for now 27th June 2019
# (Discussed with Anand to come up with new rules as existing rules appear not to work)

ini_set('display_errors', 1);
ini_set('memory_limit', -1);

ini_set("log_errors", 1);
error_reporting(E_ALL);

$minTimeOnPage = 60;
$maxBounceRate = 65;

$argv[2]          = "marshal";
$_GET['customer'] = "marshal";

$worker_log_dir = __DIR__ . '/ng_logs/_placement_logs';

if (!file_exists($worker_log_dir)) {
    if (!mkdir($worker_log_dir)) {
        die('can not create logging directory');
    }
}

$worker_logfile = $worker_log_dir . '/' . date('Y-m-d_H:i:s_') . substr((string) microtime(), 1, 8) . '.log';

ini_set("error_log", $worker_logfile);

function logme_nostrip($text)
{
    global $worker_logfile;
    file_put_contents($worker_logfile, $text . "\n", FILE_APPEND);
}

function logme($text)
{
    global $worker_logfile;
    file_put_contents($worker_logfile, strip_tags($text) . "\n", FILE_APPEND);
}

logme('Starting thread');
$grepstring = 'ps aux  | grep -v grep | grep ' . escapeshellarg('placement-filter.php') . ' | grep -v sudo';
logme($grepstring);
logme(`$grepstring`);
if (`$grepstring | wc -l` > 2) //sh and php
{
    logme("already running, quitting");
    die();
} else {
    logme("Not already running");
}

require_once 'config.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/Types.php';
require_once 'Google/Util.php';
require_once 'Google/Consts.php';
require_once 'Google/Adwords.php';
require_once 'Google/Analytics.php';
require_once 'Google/SessionManager.php';
require_once 'cron_misc.php';
require_once 'db_connect.php';
require_once 'AdSyncer.php';
require_once 'scrapper.php';
require_once 'utils.php';
require_once 'carlist-loader.php';

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
$market_buyers, $SWFConfigs, $connection, $proxy_list, $carlist, $advanced_carlist,
$BannerConfigs, $number_of_retries;

//set it to run for no timeout
secho("Trying to set timeout to no limit" . "<br/>");
set_time_limit(0);
secho("Maximum execution time: " . ini_get('max_execution_time') . "<br/><br/>");

$dealers          = [];
$common_exclusion = [];

$analytics = new Analytics(get_current_google_customer());
$filters   = "ga:timeOnPage<$minTimeOnPage,ga:bounceRate>$maxBounceRate";

foreach ($CronConfigs as $cron_name => $cron_config) {
    $domain = getDealerDomain($cron_name);
    if (!$domain) {slecho("Domain for $cron_name could not be resolved");die;}
    slecho("Dealer Domain Name: $domain");

    if (!isset($cron_config['customer_id'])) {
        slecho("CustomerId is not present for dealership $cron_name");
        continue;
    }

    $profileId = retrive_best_profileId($analytics, $domain);

    $on15 = isset($cron_config['on15']) ? $cron_config['on15'] : false;

    if ($on15) {
        $day = date('j');

        if ($day > 15) {
            $to   = time() + (60 * 60 * 24);
            $from = mktime(0, 0, 0, date('n'), 16, date('Y'));
        } else {
            $to = time() + (60 * 60 * 24);

            $month = date('n') - 1 == 0 ? 12 : date('n') - 1;
            $year  = $month == 12 ? date('Y') - 1 : date('Y');

            $from = mktime(0, 0, 0, $month, 16, $year);
        }
    } else {
        $from = mktime(0, 0, 0, date('n'), 1, date('Y'));
        $to   = time() + (60 * 60 * 24);
    }

    $analyticsStartDate = date('Y-m-d', $from);
    $analyticsEndDate   = date('Y-m-d', $to);

    if ($profileId) {
        $analyticsReport = $analytics->GetReport($profileId, $analyticsStartDate, $analyticsEndDate, $metrics = array('ga:pageviews', 'ga:timeOnPage', 'ga:bounceRate'), array('ga:campaign', 'ga:adwordsCampaignID', 'ga:adPlacementUrl', 'ga:adPlacementDomain', 'ga:pagePath'), $filters);
        if ($analyticsReport) {
            $analyticsRows = $analytics->GetAssociativeRows($analyticsReport);
            array_walk($analyticsRows, function (&$report) {
                if (startsWith($report['adPlacementUrl'], 'mobileapp::')) {
                    $report['adPlacementUrl'] = str_replace('mobileapp::2-', '', str_replace('mobileapp::1-', '', $report['adPlacementUrl'])) . '.adsenseformobileapps.com';
                }
            });

            $campaigns = [];
            $urls      = [];
            foreach ($analyticsRows as $row) {
                if ($row['pagePath'] == '/') {continue;}
                if ($row['adPlacementDomain'] == 'youtube.com') {continue;}

                if ('kijji.ca' == $row['adPlacementDomain']) {
                    if (!in_array($row['adPlacementUrl'], $urls)) {$urls[] = $row['adPlacementUrl'];}
                } else {
                    if (!in_array($row['adPlacementDomain'], $urls)) {$urls[] = $row['adPlacementDomain'];}
                }
                if (!isset($campaigns[$row['campaign']])) {
                    $campaigns[$row['campaign']] = $row['adwordsCampaignID'];
                }
            }
            $urls[] = 'adsenseformobileapps.com'; //Exclude all mobile apps at all times

            $service = new AdwordsService(
                Consts::ServiceNamespace,
                $CurrentConfig,
                $developer_token,
                $cron_config['customer_id']
            );

            slecho("Total detected urls " . count($urls));

            //Load additional URLs from file
            $exclusion_list = __DIR__ . '/data/placement-blacklist.txt';

            if (file_exists($exclusion_list)) {
                $exclusions = array_filter(file($exclusion_list), function ($line) {
                    return !!trim($line);
                });

                array_walk($exclusions, function (&$line) {
                    $line = trim($line);
                });

                $urls = array_merge($urls, $exclusions);
            }

            $common_exclusion    = array_unique(array_merge($common_exclusion, $urls));
            $dealers[$cron_name] = array(
                'campaigns' => $campaigns,
                'profileId' => $profileId,
                'start'     => $analyticsStartDate,
                'end'       => $analyticsEndDate,
            );

            foreach ($campaigns as $campaignName => $campaignId) {
                $current = $service->GetPlacements($campaignId);
                if (!$current) {$current = [];}
                $current_urls = [];

                foreach ($current as $cu) {
                    $current_urls[] = $cu->criterion->url;
                }

                $temp_urls = array_diff($urls, $current_urls);

                if (count($temp_urls) > 0) {
                    slecho("Excluding " . count($temp_urls) . " urls from $campaignName($campaignId)");
                    $service->ExcludePlacement($campaignId, $temp_urls);
                } else {
                    slecho("No new URL to exclude from $campaignName");
                }
            }
        }
    }
}

slecho("########################    Additional Exclusion    ########################");

foreach ($CronConfigs as $cron_name => $cron_config) {
    if (!isset($dealers[$cron_name])) {continue;}
    $campaigns          = $dealers[$cron_name]['campaigns'];
    $profileId          = $dealers[$cron_name]['profileId'];
    $analyticsStartDate = $dealers[$cron_name]['start'];
    $analyticsEndDate   = $dealers[$cron_name]['end'];

    $campaign_names = isset($cron_config['campaigns']) ? array_values($cron_config['campaigns']) : null;
    if (!$campaign_names) {continue;}

    array_walk($campaign_names, function (&$campaign_name) {
        $campaign_name = "ga:campaign=={$campaign_name}";
    });

    $filters = implode(',', $campaign_names);

    $analyticsReport = $analytics->GetReport($profileId, $analyticsStartDate, $analyticsEndDate, array('ga:avgTimeOnPage', 'ga:bounceRate'), array('ga:campaign'), $filters);
    if ($analyticsReport) {
        $bounceRate = $analyticsReport->totalsForAllResults->{'ga:bounceRate'};

        if ($bounceRate > 0 && $bounceRate < 70) {continue;}

        slecho("Dealer '$cron_name' bounce rate $bounceRate%");

        $service = new AdwordsService(
            Consts::ServiceNamespace,
            $CurrentConfig,
            $developer_token,
            $cron_config['customer_id']
        );

        foreach ($campaigns as $campaignName => $campaignId) {
            $current = $service->GetPlacements($campaignId);
            if (!$current) {$current = [];}
            $current_urls = [];

            foreach ($current as $cu) {
                $current_urls[] = $cu->criterion->url;
            }

            $temp_urls = array_diff($common_exclusion, $current_urls);

            if (count($temp_urls) > 0) {
                slecho("Excluding " . count($temp_urls) . " urls from $campaignName($campaignId)");

                $buffer_size = 1000;
                $pages       = ceil(count($temp_urls) / $buffer_size);

                for ($i = 0; $i < $pages; $i++) {
                    $url_batch = array_slice($temp_urls, $i * $buffer_size, $buffer_size);
                    slecho("Processing " . count($url_batch) . " urls in $i batch");
                    $service->ExcludePlacement($campaignId, $url_batch);
                }
            }
        }
    }
}
