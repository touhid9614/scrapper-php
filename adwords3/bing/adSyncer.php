<?php

function SyncBingAd($cron_name, $cron_config, $log_file_path = null)
{
    /*
     * Check account id exist or not for dealer
     */
    $account_id = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';
    if (!$account_id) {
        writeLog($log_file_path, "no bing account id found for $cron_name");
        return 0;
    }

    /*
     * There will be a function which will pause the campaign when no_adv true
     * Like MonitorCustomAccountCost
     */
    $db_connect = new DbConnect($cron_name);

    if (!($db_connect->is_bing_ad_enabled($cron_name))) {
        writeLog($log_file_path, "bing ad campaign is not enabled for $cron_name");
        return 0;
	} else {
        writeLog($log_file_path, "Sync bing ad for $cron_name, account: $account_id");
	}

    /*
     * @$cars_new => create ad group, ads |   (bing_handled_at = 0 and deleted = 0)
     * @$cars_updated  => delete existing ads and create new ads  |  (bing_handled_at > 0 and updated_at > bing_handled_at and deleted = 0)
     * @$cars_deleted => delete ads for those car | (deleted = 1)
     */
    $cars_new     = [];
    $cars_updated = [];
    $cars_deleted = [];
    $cars_all     = [];
    $db_connect->LoadCarBingAds($cars_new, $cars_updated, $cars_deleted, $cars_all, $cron_config);

    /*
     * Bing ads authentication function
     */
    getAuthentication($account_id, $log_file_path);
    /*
     * Get all campaign with account id
     */
    $db_connect->bing_sleep();
    $allCampaign = getAllCampaign($account_id);
    $Campaigns   = $allCampaign->Campaigns;
    $campaignIds = [];

    if (count((array) $Campaigns)) {
        $Campaign = $Campaigns->Campaign;
        foreach ($Campaign as $campaign_data) {
            $campaignIds[$campaign_data->Name] = $campaign_data->Id;
        }
    }

    /*
     * Get bid if set at configure file
     */
    $CpcBid = isset($cron_config['bing_bid']) ? $cron_config['bing_bid'] : 0.05;

    /*
     * ONLY FOR NEW CARS
     * Create Ads, Ads group, Campaign based on need
     */
    writeLog($log_file_path, "***** Total Number of New Car" . count($cars_new));
    foreach ($cars_new as $stock_number => $car) {
        $stock_type  = $car['stock_type'];
        $budget_name = $campaign_name = $stock_type . '_search';
        if (isset($cron_config['bing_create'])) {
            $create_ads = isset($cron_config['bing_create'][$campaign_name]) ? $cron_config['bing_create'][$campaign_name] : false;
        } else {
            $create_ads = true;
        }
        if ($create_ads) {
            try {
                writeLog($log_file_path, "car url:" . $car['url']);
                if (isset($campaignIds[$campaign_name])) {
                    $searchCampaignId = $campaignIds[$campaign_name];
                } else {
                    $db_connect->bing_sleep();
                    $budgetId = createBudget($budget_name);
                    $db_connect->bing_sleep();
                    $searchCampaignId            = createCampaign($account_id, $budgetId, $campaign_name);
                    $campaignIds[$campaign_name] = $searchCampaignId;
                    $negative_keywords           = getNegativeKeywords($car);
                    $db_connect->bing_sleep();
                    setNegativeKeyword($searchCampaignId, $negative_keywords);
                }
                writeLog($log_file_path, "campaign name: $campaign_name");
                writeLog($log_file_path, "campaign id: $searchCampaignId");
                $adGroups      = getAdGroupsByCampaignId($searchCampaignId);
                $ad_group_name = get_ad_group_name($car, $cron_name);

                if (array_key_exists($ad_group_name, $adGroups)) {
                    $adGroupId = $adGroups[$ad_group_name]->Id;
                } else {
                    $db_connect->bing_sleep();
                    $adGroupId = createAdGroup($searchCampaignId, $CpcBid, $ad_group_name);
                    $keywords  = getKeywords($car);
                    $db_connect->bing_sleep();
                    setPositiveKeyword($adGroupId, $keywords);
                }
                writeLog($log_file_path, "ad group id: $adGroupId");
                $db_connect->bing_sleep();
                createAds($adGroupId, $car, $cron_config, $cron_name, $log_file_path, $db_connect);
            } catch (Exception $ex) {
                writeLog($log_file_path, "###Exception: " . $ex->getMessage());
                writeLog($log_file_path, "###Exception code: " . $ex->getCode());
                writeLog($log_file_path, "###Exception trace: " . $ex->getTraceAsString());
            }
        }
    }

    /*
     * For updated cars
     * Get Campaign, Ads group, Ads
     * Delete Ads
     * Create Ads
     */
    writeLog($log_file_path, "***** Total Number of Updated Car" . count($cars_updated));
    foreach ($cars_updated as $stock_number => $car) {
        writeLog($log_file_path, "car url:" . $car['url']);
        $stock_type    = $car['stock_type'];
        $campaign_name = $stock_type . '_search';
        if (isset($campaignIds[$campaign_name])) {
            $searchCampaignId = $campaignIds[$campaign_name];
        }
        if (isset($searchCampaignId)) {
            try {
                writeLog($log_file_path, "campaign name: $campaign_name");
                writeLog($log_file_path, "campaign id: $searchCampaignId");
                $adGroups      = getAdGroupsByCampaignId($searchCampaignId);
                $ad_group_name = get_ad_group_name($car, $cron_name);

                if (array_key_exists($ad_group_name, $adGroups)) {
                    $adGroupId = $adGroups[$ad_group_name]->Id;
                }
                if (isset($adGroupId)) {
                    $adsId = GetAdsByAdGroupId($adGroupId);
                    if (count($adsId)) {
                        $db_connect->bing_sleep();
                        DeleteAds($adGroupId, $adsId);
                        writeLog($log_file_path, "Delete Ads Where Ad Group Id : $adGroupId");
                    }
                    $db_connect->bing_sleep();
                    createAds($adGroupId, $car, $cron_config, $cron_name, $log_file_path, $db_connect);
                }
            } catch (Exception $ex) {
                writeLog($log_file_path, "###Exception: " . $ex->getMessage());
                writeLog($log_file_path, "###Exception code: " . $ex->getCode());
                writeLog($log_file_path, "###Exception trace: " . $ex->getTraceAsString());
            }
        }
    }

    /*
     * For deleted cars
     * Get Campaign, Ads group, Ads
     * Delete Ads
     */
    writeLog($log_file_path, "***** Total Number of Deleted Car" . count($cars_deleted));
    foreach ($cars_deleted as $stock_number => $car) {
        writeLog($log_file_path, "car url:" . $car['url']);
        $stock_type    = $car['stock_type'];
        $campaign_name = $stock_type . '_search';
        if (isset($campaignIds[$campaign_name])) {
            $searchCampaignId = $campaignIds[$campaign_name];
        }
        if (isset($searchCampaignId)) {
            try {
                writeLog($log_file_path, "campaign name: $campaign_name");
                writeLog($log_file_path, "campaign id: $searchCampaignId");
                $adGroups      = getAdGroupsByCampaignId($searchCampaignId);
                $ad_group_name = get_ad_group_name($car, $cron_name);
                if (array_key_exists($ad_group_name, $adGroups)) {
                    $adGroupId = $adGroups[$ad_group_name]->Id;
                }
                if (isset($adGroupId)) {
                    $db_connect->bing_sleep();
                    DeleteAdGroups($searchCampaignId, [$adGroupId]);
                    writeLog($log_file_path, "Delete Ads Where Ad Group Id : $adGroupId");
                }
            } catch (Exception $ex) {
                writeLog($log_file_path, "###Exception: " . $ex->getMessage());
                writeLog($log_file_path, "###Exception code: " . $ex->getCode());
                writeLog($log_file_path, "###Exception trace: " . $ex->getTraceAsString());
            }
        }
    }

    /*
 * When need to create different types of ads like image ads or others some, save this code for future use if necessary

$CpcBid =   isset($cron_config['bing_bid']) ? $cron_config['bing_bid'] : 0.05;
$media_types    = [
'15x10'
];
$template       = $cron_config['banner']['template'];

foreach ($all_cars_db as $stock_number => $car) {

foreach ($media_types as $media_type) {
$url = urlCombine($AdUrlDisplay, "?utm_content={$media_type}static");
$additional_queries = get_banner_query($car, $cron_config, $media_type, $tmp_directive);
foreach ($additional_queries as $additional_query) {
//$image_data = getBanner($car, $media_type, $template, $year, $headline2, $price, $image_url1, $image_url2, $cron_config, $tmp_directive,    null, null, $additional_query);

$image = imagecreatefromstring($image_data);
$width = imagesx($image);
$height = imagesy($image);
echo 'width: ' . $width . 'h: ' . $height;
imagedestroy($image);

//$addMedia[]   =   getImageMedia($media_type, base64_encode($image_data));
//$mediaId      =   addMedia($account_id, $addMedia);
$adCreate     =   expandedTextAds($adGroupId, $cron_name, $headline, $headline2, $description, $assetName, $url);
print_r($adCreate);
}
}
//exit;
} */
}

function createAds($adGroupId, $car, $cron_config, $cron_name, $log_file_path, $db_connect)
{
    $headline  = getTextHeadline($car, $cron_config, "[year] [make] [model] [price]", false);
    $headline2 = getTextHeadline2($car, $cron_config);

    $temp_url     = str_replace('>', '', str_replace('&amp;', '&', $car["url"]));
    $AdUrlDisplay = str_replace(' ', '%20', $temp_url);
    if (!$AdUrlDisplay) {
        writeLog($log_file_path, "no add url found");
        return 0;
    }
    //utm_source is removed according to Emil's request on 05/02/2020
    //https://app.asana.com/0/687248649257779/1159990434790489
    //utm_directive is removed according to Emil's request on 30/03/2020
    https: //app.asana.com/0/687248649257779/1168601768741609
    $directive    = 'bing_smedia';
    $directivekey = $car['stock_type'] . $directive;
    $cam_search   = "smedia_search_" . $car['stock_type'];
    $AdUrlDisplay = add_query_arg(["utm_source" => $directive, "utm_medium" => "cpc", "utm_campaign" => $cam_search], $AdUrlDisplay);
    /* if (stripos($AdUrlDisplay, '?', 0) !== false)
    {
    $AdUrlDisplay .= "&utm_campaign=$cam_search&utm_medium=cpc&utm_source=$directive";
    }
    else
    {
    $AdUrlDisplay .= "?utm_campaign=$cam_search&utm_medium=cpc&utm_source=$directive";
    } */

    $descs = getDescs($car, $cron_name, $cron_config, 'search');
    foreach ($descs as $desc) {
        $title2       = $desc['title2'];
        $title3       = $desc['title3'];
        $description  = $desc['description'];
        $description2 = $desc['description2'];

        if (!$title2) {
            $title2 = $headline2;
        }

        writeLog($log_file_path, "ad url display: $AdUrlDisplay");
        $adCreate = expandedTextAds($adGroupId, $headline, $title2, $title3, $description, $description2, $AdUrlDisplay);
        $ad_id    = $adCreate->AdIds->long[0];
        writeLog($log_file_path, "created ad id: $ad_id");
    }
    if ($ad_id) {
        $db_connect->update_bing_handled($car['stock_number']);
    }
}

function setPositiveKeyword($adGroupId, $keywords)
{
    for ($i = 0; $i < count($keywords); $i++) {
        addKeyword($adGroupId, $keywords[$i]); //Broad Match Type
        addKeyword($adGroupId, '+' . str_replace(' ', ' +', $keywords[$i])); //Broad Modifier Match Type
        addKeyword($adGroupId, '"' . $keywords[$i] . '"', 'Phrase'); //Phrase Match Type
        addKeyword($adGroupId, '[' . $keywords[$i] . ']', 'Exact'); //Exact Match Type
    }
}

function setNegativeKeyword($searchCampaignId, $negative_keywords)
{
    foreach ($negative_keywords as $negative_keyword) {
        addNegativeKeyword($searchCampaignId, $negative_keyword);
    }
}

function clearFullBingAds($cron_name, $cron_config, $force = false)
{
    $account_id    = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';
    $log_file_path = __DIR__ . '/../caches/clear-bingads-log/' . $cron_name . '.txt';
    writeLog($log_file_path, "clearBingAds function called for $cron_name");
    if (!$account_id) {
        writeLog($log_file_path, "no bing account id found for $cron_name");
        return 0;
    }
    getAuthentication($account_id);
    writeLog($log_file_path, "Bing account id --> $account_id");
    $allCampaign = getAllCampaign($account_id);
    $Campaigns   = $allCampaign->Campaigns;
    $campaignIds = [];
    writeLog($log_file_path, "Bing campaign data --> " . json_encode($Campaigns));

    if (count((array) $Campaigns)) {
        $Campaign = $Campaigns->Campaign;
        foreach ($Campaign as $campaign_data) {
            writeLog($log_file_path, "Campaign name --> " . $campaign_data->Name . "             Campaign Id --> " . $campaign_data->Id);
            if (endsWith($campaign_data->Name, "_search")) {
                $campaignIds[] = $campaign_data->Id;
            }
        }
        writeLog($log_file_path, "Deleted Campaign Id --> " . json_encode($campaignIds));
        if (count($campaignIds) > 0) {
            DeleteCampaigns($account_id, $campaignIds);
            $query = "UPDATE " . $cron_name . "_scrapped_data SET `bing_handled_at` = 0";
            writeLog($log_file_path, $query);
            DbConnect::get_instance()->query($query);
        }
    }
}

function clearBingAds($cron_name, $cron_config, $force = false)
{
    $account_id    = isset($cron_config['bing_account_id']) ? $cron_config['bing_account_id'] : '';
    $log_file_path = dirname(__DIR__) . '/caches/bingads-log/clear-' . $cron_name . '.txt';
    writeLog($log_file_path, "clearBingAds function called for $cron_name");
    if (!$account_id) {
        writeLog($log_file_path, "no bing account id found for $cron_name");
        return 0;
    }
    getAuthentication($account_id);
    writeLog($log_file_path, "Bing account id --> $account_id");
    $allCampaign = getAllCampaign($account_id);
    $Campaigns   = $allCampaign->Campaigns;
    $campaignIds = [];
    writeLog($log_file_path, "Bing campaign data --> " . json_encode($Campaigns));

    if (count((array) $Campaigns)) {
        $Campaign = $Campaigns->Campaign;
        foreach ($Campaign as $campaign_data) {
            writeLog($log_file_path, "Campaign name --> " . $campaign_data->Name . "             Campaign Id --> " . $campaign_data->Id);
            if (endsWith($campaign_data->Name, "_search")) {
                $campaignId = $campaign_data->Id;
                writeLog($log_file_path, "Deleted Campaign Id --> " . $campaignId);
                $adGroups = getAdGroupsByCampaignId($campaignId);
                foreach ($adGroups as $adGroup) {
                    $adGroupId = $adGroup->Id;
                    writeLog($log_file_path, "Deleted Ad Group Id --> " . $adGroupId);
                    $adsId = GetAdsByAdGroupId($adGroupId);
                    if (count($adsId)) {
                        DeleteAds($adGroupId, $adsId);
                        writeLog($log_file_path, "Delete Ads Where Ad Group Id : $adGroupId");
                    }
                }
            }
        }
        $query = "UPDATE " . $cron_name . "_scrapped_data SET `bing_handled_at` = 0";
        writeLog($log_file_path, $query);
        DbConnect::get_instance()->query($query);
    }
}
