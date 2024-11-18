<?php

$base_path = dirname(dirname(__DIR__));
require_once $base_path . '/dashboard/config.php';

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'db_connect.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'tag_db_connect.php';

$post_url = ($_GET['api'] && $_GET['api'] == 'api') ? 'https://api.smedia.ca/v1' : 'https://api-qa.smedia.ca/v1';
echo "Post URL :: $post_url <br>";
$additional_headers['masterToken'] = '104494a70e5ab7d9fb91b1163954451cd83d28b3ae602840af6d486ed66228d17fa810b1ea08db56c5d876a69b167e12859eb404a1309978b969f6f43ebdc18b';

global $CronConfigs;

echo '<pre>';

$db_connect  = new DbConnect();
$dealer_list = $db_connect->get_all_dealers("status = 'active'");

foreach ($dealer_list as $dealer) {
    $dealer_group_name = trim($dealer['group_name']);
    $cron              = $dealer['dealership'];
    if (strlen($dealer_group_name)) {
        echo "Dealer Group Name: $dealer_group_name<br>";
    } else {
        $dealer_group_name = trim($dealer['company_name']);
        echo "Dealer Company Name: $dealer_group_name<br>";
    }

    $dealer_group_name_check = str_replace(' ', '_', $dealer_group_name);

    $post_url_dealer_group_check = $post_url . "/dealer-group-exist/$dealer_group_name_check";
    $res                         = HttpGet($post_url_dealer_group_check, false, false, '', $nothing, 'application/json', $additional_headers);
    $checkDealerGroupRes         = json_decode($res);

    if ($checkDealerGroupRes->dealerGroup) {
        $dealerGroupRes = $checkDealerGroupRes;
        echo "Dealer Group Exist<br>";
    } else {
        echo "Dealer Group NOT Exist<br>";
        $finalObject                    = [];
        $finalObject['dealerGroupName'] = $dealer_group_name;
        $post_data                      = json_encode($finalObject);

        $post_url_dealer_group = $post_url . '/dealer-group';
        $res                   = HttpPost($post_url_dealer_group, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
        $dealerGroupRes        = json_decode($res);

    }

    $dealerGroupId = isset($dealerGroupRes->id) ? $dealerGroupRes->id : false;

    if ($dealerGroupId) {
        echo "Dealer Group Id:: " . $dealerGroupId . "<br>";
        $finalObject = [];
        echo 'Cron Name: ' . $cron . '<br>';
        $dealer_info = $dealer;
        $website     = $dealer_info['websites'];

        if (!preg_match('#^http(s)?://#', $website)) {
            $website = 'http://' . $website;
        }

        $domain = parse_url($website, PHP_URL_HOST);
        echo 'Website: ' . $domain . '<br>';

        $post_url_dealer_check = $post_url . "/dealer-exist/$domain";
        $res                   = HttpGet($post_url_dealer_check, false, false, '', $nothing, 'application/json', $additional_headers);
        $checkDealerRes        = json_decode($res);

        $finalObject['dealerName'] = $dealer_info['company_name'];
        $finalObject['cronName']   = $cron;

        if (array_key_exists($cron, $CronConfigs)) {
            $cron_config         = $CronConfigs[$cron];
            $adwords_tracking_id = isset($cron_config['customer_id']) ? $cron_config['customer_id'] : '';
            $bing_account_id     = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';
        }

        $ids['analytics_tracking_id'] = get_meta('tracking_ids', "{$cron}_analytics_tracking_id");
        $ids['facebook_pixel_id']     = get_meta('tracking_ids', "{$cron}_facebook_pixel_id");
        $ids['snapchat_pixel_id']     = get_meta('tracking_ids', "{$cron}_snapchat_pixel_id");
        $ids['adwords_tracking_id']   = $adwords_tracking_id;
        $ids['bing_tag_id']           = $bing_account_id;

        if (!empty($ids['analytics_tracking_id'])) {
            $finalObject['setting']['analyticAccountId'][] = array(
                "idNo" => $ids['analytics_tracking_id'],
            );
        }

        if (!empty($ids['adwords_tracking_id'])) {
            $finalObject['setting']['googleAdAccountId'][] = array(
                "idNo" => $ids['adwords_tracking_id'],
            );
        }

        if (!empty($ids['bing_tag_id'])) {
            $finalObject['setting']['bingAdAccountId'][] = array(
                "idNo" => $ids['bing_tag_id'],
            );
        }

        if (!empty($ids['snapchat_pixel_id'])) {
            $finalObject['setting']['snapchatPixelId'][] = array(
                "idNo" => $ids['snapchat_pixel_id'],
            );
        }

        if (!empty($ids['facebook_pixel_id'])) {
            $finalObject['setting']['fbPixelId'][] = array(
                "idNo" => $ids['facebook_pixel_id'],
            );
        }

        if (!empty($dealer_info['fb_page_id'])) {
            $finalObject['setting']['fbPageId'][] = array(
                "idNo" => $dealer_info['fb_page_id'],
            );
        }

        $serviceExist  = false;
        $serviceObject = [];

        if ($checkDealerRes->dealer) {
            echo "<br>Dealer Exist<br>";
            $dealershipId    = $checkDealerRes->dealershipId;
            $post_url_dealer = $post_url . "/dealer/$dealershipId";
            if (count($checkDealerRes->service)) {
                $serviceObject = $checkDealerRes->service;
                foreach ($checkDealerRes->service as $service) {
                    if ($service->name == 'dashboard') {
                        $serviceExist = true;
                        break;
                    }
                }
            }
            if (!$serviceExist) {
                $serviceObject[] = array(
                    "name" => "dashboard",
                );
                $finalObject['service'] = $serviceObject;
            }
        } else {
            $finalObject['domain']    = $domain;
            $finalObject['service'][] = array(
                "name" => "dashboard",
            );
            $post_url_dealer = $post_url . '/dealer';
        }

        $post_data = json_encode($finalObject);
        $res       = HttpPost($post_url_dealer, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
        $dealeRes  = json_decode($res);

        echo 'Dealer Id: ' . $dealeRes->id . '<br>';

        $dealerId     = isset($dealeRes->id) ? $dealeRes->id : false;
        $dealerDomain = isset($dealeRes->domain) ? $dealeRes->domain : false;
        $dealerName   = isset($dealeRes->dealerName) ? $dealeRes->dealerName : false;

        $dealerExistInDealerGroup = false;

        if (count($dealerGroupRes->dealerships)) {
            foreach ($dealerGroupRes->dealerships as $dealer) {
                if ($dealer->dealershipId == $dealerId) {
                    $dealerExistInDealerGroup = true;
                    break;
                }
            }
        }

        if ($dealerId) {
            if ($dealerExistInDealerGroup) {
                echo '<br>Dealer Info already exist in Dealer Group <br>';
            } else {

                $dealerObject                 = [];
                $finalObject                  = [];
                $dealerObject['dealershipId'] = $dealerId;
                $dealerObject['domain']       = $dealerDomain;
                $dealerObject['name']         = $dealerName;
                $finalObject['dealerships'][] = $dealerObject;
                $post_data                    = json_encode($finalObject);

                $post_url_dealership_update = $post_url . '/dealer-group-dealership/' . $dealerGroupId;

                $res            = HttpPost($post_url_dealership_update, $post_data, '', $nothing, false, false, 'application/json', $additional_headers);
                $dealerGroupRes = json_decode($res);

                if (count($dealerGroupRes->dealerships)) {
                    echo 'Dealer Info Push to Dealer Group <br>';
                } else {
                    echo 'ERROR:: Dealer Info Not Push to Dealer Group <br>';
                }
            }
        } else {
            echo 'ERROR:: Dealer Id Not found <br>';
        }
        echo '------------------------<br>';

    } else {
        echo "<br>ERROR :: When Dealer Group Create<br>";
    }

    echo "<br>==========================<br>";
}
exit();