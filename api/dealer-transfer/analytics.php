<?php

if (!defined('NO_REDIRECT')) {
    define('NO_REDIRECT', true);
}

ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';

$_GET['customer'] = isset($_GET['customer']) ? $_GET['customer'] : 'reporting';

require_once ADSYNCPATH . 'Google/TokenHelper.php';
require_once ADSYNCPATH . 'Google/Types.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'Google/Consts.php';
require_once ADSYNCPATH . 'Google/Analytics.php';
require_once ADSYNCPATH . 'Google/SessionManager.php';

require_once 'email.php';

global $CronConfigs, $CurrentConfig, $developer_token, $google_config_new, $google_account;

$_GET['api']                       = 'api';
$post_url                          = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-qa.smedia.ca/v1';
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

$my_debug    = filter_input(INPUT_GET, 'my_debug') == '1';
$pull_static = isset($_GET['one']) ? true : false;

if (!$pull_static) {
    $post_url_dealer_id_pull = $post_url . "/dealer-account-id/analytics";
    $res                     = HttpGet($post_url_dealer_id_pull, false, false, '', $nothing, 'application/json', $additional_headers);
    $dealerships             = json_decode($res);
}

$dealer_cron_name = isset($_GET['dealer']) ? $_GET['dealer'] : '';
$allMonth         = isset($_GET['month']) ? true : false;

if ($allMonth) {
    if ($_GET['month'] == 2018) {
        $year  = ['2018'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else if ($_GET['month'] == 2019) {
        $year  = ['2019'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else if ($_GET['month'] == 2020) {
        $year  = ['2020'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else if ($_GET['month'] == 2021) {
        $year  = ['2021'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    } else {
        $year  = ['2018', '2019', '2020', '2021'];
        $month = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    }
} else {
    $current_year  = date('Y');
    $current_month = date('m');
    $year          = [$current_year];
    $month         = [$current_month];
}

$mail_report = [];

foreach ($dealerships as $dealer) {
    if ($pull_static) {
        $dealerName            = 'winnipeghondaca';
        $domain                = 'winnipeghondaca';
        $cron_name             = 'winnipeghondaca';
        $id                    = '60126bf2aa1fc3001e0bfd57';
        $account_id            = 'UA-87938904-1';
        $profile_id            = '218611782';
        $dealer_data_need_pull = true;
    } else {
        $dealerName            = $dealer->dealerName;
        $domain                = $dealer->domain;
        $cron_name             = $dealer->cronName;
        $id                    = $dealer->id;
        $account               = $dealer->account_id;
        $profile               = $dealer->profile;
        $dealer_data_need_pull = true;

        if (!empty($dealer_cron_name)) {
            if ($cron_name !== $dealer_cron_name) {
                $dealer_data_need_pull = false;
            }
        }
    }

    if ($dealer_data_need_pull) {
        $mail_report[$cron_name] = "unsuccessful";
        $log_file_path           = dirname(dirname(__DIR__)) . '/adwords3/caches/report-log/' . $cron_name . '-analytic.txt';
        writeLog($log_file_path, "***** ***** ***** *****");
        writeLog($log_file_path, "ID: $id");
        writeLog($log_file_path, "Dealer name: $dealerName");
        writeLog($log_file_path, "Domain name: $domain");
        writeLog($log_file_path, "Cron name: $cron_name");

        $vdp_regexes = load_vdp_configs(ADSYNCPATH . "data/vdp-config.json", $dealer_cron_name);

        if (!$pull_static) {
            $account_id = false;

            foreach ($account as $account_info) {
                if ($account_info->active && $account_info->dataPull) {
                    $account_id   = $account_info->idNo;
                    $account_name = $account_info->account;
                }
            }

            $profile_id = false;

            foreach ($profile as $profile_info) {
                if ($profile_info->active && $profile_info->dataPull) {
                    $profile_id = $profile_info->idNo;
                    if (!$account_name) {
                        $account_name = $profile_info->account;
                    }
                }
            }
        }

        echo "Id: $id <br>";
        echo "Dealer name: $dealerName<br>";
        echo "Domain: $domain<br>";
        echo "Cron name: $cron_name<br>";

        if (!$account_id) {
            writeLog($log_file_path, "No Analytics account id found in DB");
            echo "<br>No Google account id found in DB";
        } else {
            writeLog($log_file_path, "Analytics account id : $account_id");
            echo "<br>Analytics account id : $account_id<br>";
        }

        if ($account_name && array_key_exists($account_name, $google_config_new)) {
            writeLog($log_file_path, "Analytics account Key Exists : $account_name");
            echo "Analytics account Key Exists : $account_name<br>";
            $_GET['customer']     = $account_name;
            $_SESSION['customer'] = $account_name;
            $analytics            = new Analytics($account_name);
        } else {
            $account_name = get_current_google_customer();
            $analytics    = new Analytics($account_name);
        }

        if ($my_debug) {
            echo "<br>Analytics : <br>";
            print_r($analytics);
        }

        $pro_id = false;

        if (!$profile_id) {
            writeLog($log_file_path, "No Profile id found in DB");
            echo "No Profile id found in DB<br>";

            $googleAccount = $analytics->GetAccountSummaries();

            if ($googleAccount) {
                writeLog($log_file_path, "Data found for Profile Id");
                echo "Data found for Profile Id <br>";

                if ($my_debug) {
                    echo "<br>Profile Id Data : <br>";
                    print_r($googleAccount);
                }

                foreach ($googleAccount->items as $account) {
                    foreach ($account->webProperties as $webProperties) {
                        if ($webProperties->id == $account_id) {
                            writeLog($log_file_path, "Account Id Match");
                            echo "Account Id Match<br>";

                            foreach ($webProperties->profiles as $profiles) {
                                if (count($webProperties->profiles) == 1) {
                                    $profile_id = $profiles->id;
                                    $pro_id     = true;
                                    break 3;
                                } else {
                                    $profileName = strtolower($profiles->name);
                                    if (strpos($profileName, 'smedia') !== false) {
                                        $profile_id = $profiles->id;
                                        $pro_id     = true;
                                        break 3;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                writeLog($log_file_path, "No data for found Profile Id");
                echo "<br>No data for found Profile Id <br>";
            }
        }

        if ($profile_id) {
            writeLog($log_file_path, "Profile Id: $profile_id");
            echo "Profile Id: $profile_id<br><br>";

            if ($pro_id) {
                $finalObject = [];
                $finalObject = array(
                    "idNo"    => $profile_id,
                    "account" => $account_name ? $account_name : false,
                );

                $post_data       = json_encode($finalObject);
                $post_url_dealer = $post_url . "/dealer/$id/profileId";
                $res             = HttpPost($post_url_dealer, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
            }

            foreach ($year as $y) {
                foreach ($month as $m) {
                    $sdate    = $y . '-' . $m . '-01';
                    $date     = new DateTime($sdate);
                    $edate    = $date->format('Y-m-t');
                    $date_now = date("Y-m-d");

                    $ym = $y . $m;

                    if ($date_now > $sdate) {
                        echo "<br>Date : $sdate :: $edate <br>";
                        writeLog($log_file_path, "Date - $sdate :: $edate");

                        $report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:users', 'ga:newUsers', 'ga:sessions', 'ga:bounceRate', 'ga:pageviewsPerSession', 'ga:avgSessionDuration'), array('ga:sourceMedium', 'ga:campaign'));

                        $finalData = [];

                        if (!$report->rows) {
                            echo '<b>No Data Found </b><br>';
                            writeLog($log_file_path, "No Data Found");
                        } else {
                            echo '<b>Data Found</b><br>';
                            writeLog($log_file_path, "Data Found");

                            foreach ($report->rows as $row) {
                                $dataArray                       = [];
                                $dataArray['sourceMedium']       = $row[0];
                                $dataArray['campaign']           = $row[1];
                                $dataArray['users']              = $row[2];
                                $dataArray['newUser']            = $row[3];
                                $dataArray['sessions']           = $row[4];
                                $dataArray['bounceRate']         = $row[5];
                                $dataArray['pagesPerSession']    = $row[6];
                                $dataArray['avgSessionDuration'] = gmdate("H:i:s", $row[7]);

                                $finalData[] = $dataArray;
                            }

                            $report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:sessions'), array('ga:sourceMedium', 'ga:campaign', 'ga:eventCategory'));

                            if (!$report || !$report->rows) {
                                echo 'No Row Found for engaged Prospects <br>';
                                writeLog($log_file_path, "No Row Found for engaged Prospects");
                            } else {
                                echo 'Row Found for engaged Prospects <br>';
                                writeLog($log_file_path, "Row Found for engaged Prospects");
                                foreach ($report->rows as $row) {
                                    if ($row[2] == "Profitable Engagement") {
                                        foreach ($finalData as $key => $item) {
                                            if ($item['sourceMedium'] == $row[0] && $item['campaign'] == $row[1]) {
                                                $finalData[$key]['engagedProspects'] = $row[3];
                                                $finalData[$key]['epConvRate']       = ($finalData[$key]['engagedProspects'] / $finalData[$key]['sessions']) * 100;
                                            }
                                        }
                                    }
                                }
                            }

                            try {
                                $time_on_page_report = $analytics->GetReport($profile_id, date($sdate), date($edate), array('ga:timeOnPage'), array('ga:sourceMedium', 'ga:campaign', 'ga:pagePath', 'ga:hostname'));
                                if (!empty($time_on_page_report) && isset($time_on_page_report->rows) && is_array($time_on_page_report->rows)) {
                                    $time_on_vdp_report = filter_vdp_data($time_on_page_report->rows, $vdp_regexes);
                                } else {
                                    writeLog($log_file_path, "No timeOnPage data found");
                                }
                            } catch (Exception $e) {
                                writeLog($log_file_path, $e->getMessage());
                            }

                            unset($time_on_page_report);

                            if (isset($time_on_vdp_report) && !empty($time_on_vdp_report) && is_array($time_on_vdp_report)) {
                                $acc_report = [];
                                foreach ($time_on_vdp_report as $row) {
                                    $key = "{$row[0]}||{$row[1]}";
                                    if (!isset($acc_report[$key])) {
                                        $acc_report[$key] = ["total_time" => 0, 'count' => 0];
                                    }
                                    $acc_report[$key]["total_time"] += floatval($row[4]);
                                    $acc_report[$key]["count"] += 1;
                                }

                                foreach ($finalData as $key => $item) {
                                    $acc_key                         = "{$item['sourceMedium']}||{$item['campaign']}";
                                    $avg                             = $acc_report[$acc_key]["count"] > 0 ? $acc_report[$acc_key]["total_time"] / $acc_report[$acc_key]["count"] : 0;
                                    $finalData[$key]['avgTimeOnVdp'] = gmdate("H:i:s", $avg);
                                }
                                unset($acc_report);
                                unset($time_on_vdp_report);
                            }

                            $myObj                 = [];
                            $myObj['dealerId']     = $id;
                            $myObj['key']          = "analytics";
                            $myObj['data']['date'] = $ym;
                            $myObj['data']['data'] = $finalData;
                            $post_data             = json_encode($myObj);

                            $post_url_data_push = $post_url . "/dealer-data";
                            $res                = HttpPost($post_url_data_push, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);

                            print_r($post_data);
                            echo "<br>";
                            print_r($res);
                            writeLog($log_file_path, "Response ::  $res");
                            $mail_report[$cron_name] = "successful";
                        }

                        echo "<br><br>========================";
                    }
                }
            }
        } else {
            writeLog($log_file_path, "No Profile Id");
            echo "No Profile Id";
        }

        echo "<br><br>*************************************** <br><br>";
    }
}

report_mail("Analytics", $mail_report);

function load_vdp_configs($file_path, $dealership)
{
    if (file_exists($file_path)) {
        try {
            $json_content = file_get_contents($file_path);
            if ($json_content) {
                $json = json_decode($json_content);
            }
            if (isset($json) && isset($json->configs)) {
                $configs = $json->configs;
                foreach ($configs as $c) {
                    if (isset($c->domain_key) && $c->domain_key == $dealership) {
                        return isset($c->vdp_url_regex) ? $c->vdp_url_regex : null;
                    }
                }
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    return null;
}

function filter_vdp_data($data, $vdp_rgexes)
{
    return array_filter($data, function ($v) use ($vdp_rgexes) {
        foreach ($vdp_rgexes as $r) {
            preg_match($r, $v[2], $match);
            if (count($match) > 0) {
                return true;
            }
        }
        return false;
    });
}