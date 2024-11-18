<?php

$_GET['customer'] = 'marshal'; // To bypass customer reference

require_once 'utils.php';
require_once 'config.php';
require_once 'report_db_connect.php';
require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';
require_once 'tag_db_connect.php';

$analytics = new Analytics(get_current_google_customer());
$url       = filter_input(INPUT_GET, 'url');

if (!$url) {
    $url = 'https://www.performancehondabountiful.com/new-inventory/index.htm'; #just a test
}

foreach ($url_data as $url) {
    $domain    = GetDomain($url);
    $cron_name = getDomainDealer($domain, $url);
    $profileId = retrive_best_profileId($analytics, $domain);

    if (!$profileId) {
        echo $url . " --- no profileId\n";
        continue;
    }

    $metrics = array(
        'ga:sessions',
        'ga:bounces',
        'ga:bounceRate',
        'ga:sessionDuration',
        'ga:avgSessionDuration',
        'ga:hits',
        'ga:pageviews',
        'ga:avgTimeOnPage',
    );
    $dimensions = array(
        // 'ga:eventCategory',
        // 'ga:eventAction',
        // 'ga:eventLabel'
    );
    $filter = "";
    $report = $analytics->GetReport($profileId, $startDate->format('Y-m-d'), date('Y-m-d'), $metrics, $dimensions, $filter);

    if (count(@$report->{'rows'}) > 0) {
        // Save to db
        reportdb_store_adwords_session($profileId, $profileId, $report->{'rows'});
    } else {
        echo "no rows - profile\n";
    }

    $metrics = array(
        'ga:totalEvents',
        'ga:uniqueEvents',
        'ga:eventValue',
        'ga:avgEventValue',
        'ga:sessionsWithEvent',
        'ga:eventsPerSessionWithEvent',
    );
    $dimensions = array(
        // 'ga:eventCategory',
        // 'ga:eventAction',
        // 'ga:eventLabel'
    );
    $filter = "";
    $report = $analytics->GetReport($profileId, $startDate->format('Y-m-d'), date('Y-m-d'), $metrics, $dimensions, $filter);

    if (count(@$report->{'rows'}) > 0) {
        // Save to db
        reportdb_store_adwords_event_tracking($profileId, $profileId, $report->{'rows'});
    } else {
        echo "no rows - profile\n";
    }
}

echo "done successfully!";
