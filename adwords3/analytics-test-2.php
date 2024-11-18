<?php

require_once 'utils.php';
require_once 'config.php';
require_once 'tag_db_connect.php';
$_GET['customer'] = 'marshal';
require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';

global $CronConfigs, $scrapper_configs;

$cron_names = array_intersect(array_keys($CronConfigs), array_keys($scrapper_configs));

$result = [];
$co     = 0;
echo '<pre>';

foreach ($cron_names as $cron_name) {
    echo "<br>$cron_name<br>";
    $domain = getDealerDomain($cron_name);
    echo "<br>domain <br>";
    echo $domain;
    print_r($CurrentConfig);
    $analytics = new Analytics(get_current_google_customer());
    echo "<br>analytics <br>";
    print_r($analytics);
    $profileId = retrive_best_profileId($analytics, $domain);
    echo "<br>profileId <br>";
    print_r($profileId);

    $startDate = new DateTime(date('Y-m-d'));
    $startDate->sub(new DateInterval('P90D'));

    $report = $analytics->GetReport($profileId, $startDate->format('Y-m-d'), date('Y-m-d'), array('ga:bounceRate'), array('ga:date'));
    echo "<br>report <br>";
    print_r($report);

    if (!$report || !$report->rows) {
        continue;
    }

    foreach ($report->rows as $row) {
        if (!isset($result[$row[0]])) {
            $result[$row[0]] = array(
                'accumulatedBR' => $row[1],
                'count'         => 1,
            );
        } else {
            $result[$row[0]]['accumulatedBR'] += $row[1];
            $result[$row[0]]['count']++;
        }
    }

    if ($co == 5) {
        break;
    }

    $co++;
}

echo json_encode($result);
