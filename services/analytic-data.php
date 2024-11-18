<?php

use Illuminate\Database\Capsule\Manager as DB;

$base_dir    = dirname(__DIR__) . "/";
$adwords_dir = $base_dir . "adwords3/";

require_once $adwords_dir . 'config.php';
require_once $base_dir . 'includes/init-db.php';
require_once $adwords_dir . 'utils.php';
require_once $adwords_dir . 'tag_db_connect.php';

$_GET['customer'] = 'marshal';

require_once $adwords_dir . 'Google/Consts.php';
require_once $adwords_dir . 'Google/TokenHelper.php';
require_once $adwords_dir . 'Google/SessionManager.php';
require_once $adwords_dir . 'Google/Analytics.php';

$client = new MongoDB\Client(
    'mongodb://smedia:6Qrt2WPqd4qB3HUvzG@mongo-dev.smedia.ca:27017/smedia_apps?authSource=admin&readPreference=primary&appname=smedia&ssl=false'
);

$db                   = $client->smedia_apps;
$dealershipCollection = $db->dealerships;

$cursors = $dealershipCollection->find();

//foreach ($cursors as $dealership) {
//    echo "Dealer: ".$dealership['dealerName']."<br>";
//    echo "Domain: ".$dealership['domain']."<br>";
//    echo "==============<br>";
//}

$dealership_domains = [];

$query = DB::table('dealerships')->select(['dealership', 'websites']);

foreach ($cursors as $dealership) {
    $id                             = (array) $dealership['_id'];
    $dealership_domains[$id['oid']] = $dealership['domain'];
    $query->orWhere('websites', 'regexp', "^https{0,1}://(www.)*({$dealership['domain']})/*");
}

$results = $query->get();

$dealerships = [];
foreach ($results as $r) {
    $domain = preg_replace("/^https{0,1}:\/\/(www.)*([^\/]*)\/.*/", '$2', $r->websites);
    $id     = array_search($domain, $dealership_domains);
    if ($id) {
        //$dealerships[$id] = $r->dealership;
        $dealerships[$r->dealership] = $id;
    }
}

echo '<pre>';
//print_r($dealerships);

foreach ($dealerships as $cron_name => $id) {
    echo "Cron_name: $cron_name<br>";
    $domain = getDealerDomain($cron_name);
    echo "Domain: $domain <br>";
    echo "Id: $id <br>";

    $analytics = new Analytics(get_current_google_customer());
    $data      = $analytics->GetHostSummary($domain);
    if (!$data) {
        echo " No data for profileId <br>";
    } else {
        $profileId = null;
        $pageViews = 0;

        foreach ($data as $report) {
            if ($profileId == null) {
                $profileId = $report->profileInfo->profileId;
                $pageViews = $report->totalsForAllResults->{'ga:pageviews'};
            } elseif ($report->totalsForAllResults->{'ga:pageviews'} > $pageViews) {
                $profileId = $report->profileInfo->profileId;
                $pageViews = $report->totalsForAllResults->{'ga:pageviews'};
            }
        }

        echo "<br>profileId : $profileId <br>";

        $year  = ['2019', '2020'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        foreach ($year as $y) {
            foreach ($month as $m) {
                $sdate = $y . '-' . $m . '-01';
                $date  = new DateTime($sdate);
                $edate = $date->format('Y-m-t');

                $date_now = date("Y-m-d");
                if ($date_now > $edate) {
                    echo "Date : $sdate :: $edate :: $profileId<br>";
                    $report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:users', 'ga:sessions'), array('ga:sourceMedium', 'ga:campaign'));
//                    echo "Report : <br>";
                    //                    print_r($report);
                    $finalData = array();
                    if (!$report->rows) {
                        echo '<br><b>No Data Found </b><br>';
                    } else {
                        foreach ($report->rows as $row) {
                            $dataArray                 = array();
                            $dataArray['sourceMedium'] = $row[0];
                            $dataArray['campaign']     = $row[1];
                            $dataArray['users']        = $row[2];
                            $dataArray['sessions']     = $row[3];
                            $finalData[]               = $dataArray;
                        }

                        $report = $analytics->GetReport($profileId, date($sdate), date($edate), array('ga:sessions'), array('ga:sourceMedium', 'ga:campaign', 'ga:eventCategory'));
//                      echo "Report of engaged Prospects  : <br>";
                        //                      print_r($report);
                        if (!$report || !$report->rows) {
                            echo '<br>No Row Found for engaged Prospects <br>';
                        } else {
                            foreach ($report->rows as $row) {
                                if ($row[2] == "Profitable Engagement") {
                                    foreach ($finalData as $key => $item) {
                                        if ($item['sourceMedium'] == $row[0] && $item['campaign'] == $row[1]) {
                                            $finalData[$key]['engagedProspects'] = $row[3];
                                        }
                                    }
                                }
                            }
                        }
                    }

//                    print_r($finalData);
                    //                    echo "==============<br>";

                    $myObj                 = array();
                    $myObj['dealerId']     = $id;
                    $myObj['key']          = "campaignCosts";
                    $myObj['data']['date'] = $sdate;
                    $myObj['data']['data'] = $finalData;
                    // $myObj->data = $finalData;
                    $post_data = json_encode($myObj);

                    $res = HttpPost('https://api-dev.smedia.ca/engaged-prospect', $post_data, '', $nothing, false, false, 'application/json');
                    print_r($post_data);
                    echo "<br>===================<br>";
                }
            }
        }
    }
    echo "<br><br>*************************************** <br><br>";
}
