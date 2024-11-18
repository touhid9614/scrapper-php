<?php

$_GET['customer'] = 'marshal'; //To bypass customer reference

require_once    'utils.php';
require_once    'config.php';
require_once    'tag_db_connect.php';
require_once    'Google/Consts.php';
require_once    'Google/TokenHelper.php';
require_once    'Google/SessionManager.php';
require_once    'Google/Analytics.php';

$url = filter_input(INPUT_GET, 'url');

if(!$url){
    $url = 'http://www.barbermotors.com/VehicleSearchResults?search=new';   #just a test
}

$analytics = new Analytics(get_current_google_customer());

$domain         = GetDomain($url);
$cron_name      = getDomainDealer($domain, $url);
$profileId      = retrive_best_profileId($analytics, $domain);

//die(print_r($profileId, true));

var_dump($analytics->GetViewProfilesByHostname($domain));

$startDate = new DateTime(date('Y-m-d'));
$startDate->sub(new DateInterval('P60M'));

$urlReport = $analytics->GetReport($profileId, $startDate->format('Y-m-d'), date('Y-m-d'),
        /* metrics      */  array('ga:pageviews', 'ga:eventValue'),
        /* dimensions   */  array('ga:eventCategory', 'ga:eventAction', 'ga:eventLabel'),
        /* filter       */  "ga:eventCategory==Profitable Engagement");

$urlReport2 = $analytics->GetReport($profileId, $startDate->format('Y-m-d'), date('Y-m-d'),
        /* metrics      */  array('ga:pageviews', 'ga:eventValue'),
        /* dimensions   */  array('ga:eventCategory', 'ga:eventAction', 'ga:eventLabel'),
        /* filter       */  "ga:eventCategory==managedPage");

/*
 * We are interested in
 * 
 * EventCategory: managedPage
 * EventAction  : view
 * EventLabel   : [This is Our unique ID]
 * EventValue   : [This is Our integer ID]
 * 
 * Not all matrics dimensions combination are supported
 * Please check following link for details
 * https://developers.google.com/analytics/devguides/reporting/core/dimsmets
 */

echo "URL Report: Profitable Engagement";
$analytics->DumpObject($urlReport);

echo "URL Report: managedPage";
$analytics->DumpObject($urlReport2);

echo "Best Profile ID:";
$analytics->DumpObject($profileId);

echo "Total Pageviews:";
$analytics->DumpObject($urlReport->totalsForAllResults->{'ga:pageviews'});