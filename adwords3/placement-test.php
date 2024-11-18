<?php

ini_set('memory_limit', -1);

$minTimeOnPage = 60;
$maxBounceRate = 65;

$_GET['customer'] = "marshal";

require_once 'config.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/Types.php';
require_once 'Google/Util.php';
require_once 'Google/Consts.php';
require_once 'Google/Adwords.php';
require_once 'Google/Analytics.php';
require_once 'Google/SessionManager.php';
require_once 'cron_misc.php';
//require_once('db_connect.php');
require_once 'AdSyncer.php';
require_once 'scrapper.php';
require_once 'utils.php';
require_once 'carlist-loader.php';

global $CronConfigs, $scrapper_configs, $CurrentConfig, $developer_token,
$market_buyers, $SWFConfigs, $connection, $proxy_list, $carlist, $advanced_carlist,
$BannerConfigs, $number_of_retries;

//set it to run for no timeout
slecho("Trying to set timeout to no limit");
set_time_limit(0);
slecho("Maximum execution time: " . ini_get('max_execution_time'));

$dealers          = [];
$common_exclusion = [];

$analytics = new Analytics(get_current_google_customer());
$filters   = "ga:timeOnPage<$minTimeOnPage,ga:bounceRate>$maxBounceRate";

$cron_name = filter_input(INPUT_GET, 'dealer') ? filter_input(INPUT_GET, 'dealer') : 'inlandautoinlandautocentre';

$cron_config = $CronConfigs[$cron_name];

$domain = getDealerDomain($cron_name);
if (!$domain) {slecho("Domain for $cron_name could not be resolved");die;}
slecho("Dealer Domain Name: $domain");

if (!isset($cron_config['customer_id'])) {
    die("CustomerId is not present for dealership $cron_name");
}

$profileId = retrive_best_profileId($analytics, $domain);

slecho("Best profile ID $profileId");

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

            slecho("Already excluded urls " . count($current_urls));

            $temp_urls = array_diff($urls, $current_urls);

            if (count($temp_urls) > 0) {
                slecho("Excluding " . count($temp_urls) . " urls from $campaignName($campaignId)");
                $service->ExcludePlacement($campaignId, $temp_urls);
            } else {
                slecho("No new URL to exclude from $campaignName($campaignId)");
            }
        }
    }
}
