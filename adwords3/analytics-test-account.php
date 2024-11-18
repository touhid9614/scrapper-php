<?php

require_once 'utils.php';
require_once 'config.php';
require_once 'tag_db_connect.php';

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'marshal';

require_once 'Google/Consts.php';
require_once 'Google/TokenHelper.php';
require_once 'Google/SessionManager.php';
require_once 'Google/Analytics.php';

$cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : 'titanauto';

$result = [];
echo '<pre>';

echo "Cron_name: $cron_name<br>";
$domain = getDealerDomain($cron_name);
echo "Domain: $domain <br>";

echo "==================<br>";
echo "<br> Current Config <br>";
print_r($CurrentConfig);
echo "==================<br>";

$analytics = new Analytics(get_current_google_customer());
echo "<br>Analytics <br>";
print_r($analytics);
echo "==================<br>";

$data = $analytics->GetHostSummary($domain);
echo "<br>Data for profileId: <br>";
print_r($data);
if (!$data) {
    echo " No data for profileId <br>";
}
echo "==================<br>";

$profileId = null;
$pageViews = 0;

foreach ($data as $report) {
    $profileName = strtolower($report->profileInfo->profileName);
    if (strpos($profileName, 'smedia') !== false) {
        $profileId = $report->profileInfo->profileId;
        break;
    }
}

echo "<br>profileId : $profileId";
