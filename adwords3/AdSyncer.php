<?php

define("REDUCE_COST", true);

require_once __DIR__ . '/utils.php';

/**
 * { function_description }
 *
 * @param      <type>  $cron_name        The cron name
 * @param      <type>  $cron_config      The cron configuration
 * @param      <type>  $CurrentConfig    The current configuration
 * @param      <type>  $developer_token  The developer token
 * @param      <type>  $market_buyers    The market buyers
 * @param      <type>  $SWFConfigs       The swf configs
 * @param      <type>  $BannerConfigs    The banner configs
 */
function SyncAd($cron_name, $cron_config, $CurrentConfig, $developer_token, $market_buyers, $SWFConfigs, $BannerConfigs)
{
    slecho("CronConfigs: " . json_encode($cron_config));
    create_meta_table('campaign_budget');

    $cars_db     = [];
    $ads_db      = [];
    $all_cars_db = [];

    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $cron_config['customer_id']
    );

    // Support no advertisement syncing
    if (isset($cron_config['no_adv']) && $cron_config['no_adv']) {
        if (isset($cron_config['max_cost'])) {
            MonitorCustomAccountCost($cron_name, $cron_config, $CurrentConfig, $developer_token);
			MonitorAccountCost($service, $cron_name, $cron_config);
        }

        return;
    }

    // Customer ID isn't configured
    if (!isset($cron_config['customer_id'])) {
        slecho("Warning: adwords customer_id isn't configured. No adwords ads will be created.");
        return;
    }

    $db_connect = new DbConnect($cron_name);

    // varify template hash
    $calculated_hash = calculate_template_hash($cron_name);
    $stored_hash     = $db_connect->retrive_template_hash($cron_name);
    $hst             = isset($cron_config['banner']['hst']) ? $cron_config['banner']['hst'] : false;

    slecho("Current template hash: '$calculated_hash' and stored hash '$stored_hash'");

    if (is_null($stored_hash)) {
        $stored_hash = $calculated_hash;
        $db_connect->store_template_hash($cron_name, $calculated_hash);
        slecho('Info: Registering template state for the first time, No existing advertisment will be recreated.');
        slecho('Template Hash: ' . $calculated_hash . ' any change in this template will force existing ads to recreate');
    }

    if ($calculated_hash != $stored_hash) {
        $db_connect->reset_cars(); // this will force all handled cars that are not deleted to appear as updated
        $db_connect->store_template_hash($cron_name, $calculated_hash);
        slecho('Info: Template has been changed, all existing advertisements will be recreated');
        slecho('Old Hash: ' . $stored_hash . ' Current Hash: ' . $calculated_hash);
    }

    $db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);

    slecho('Info: cost monitor: running');
    MonitorAccountCost($service, $cron_name, $cron_config);

    $campaignIds = [];
    $budgetId    = null;

    foreach ($cron_config['campaigns'] as $key => $campaign_name) {
        slecho("Info: Getting campaign Id for campaign '" . $campaign_name . "'");

        // Get campaign
        $entities = $service->GetCampaign($campaign_name);
        $search   = false;
        $display  = true;

        if (endsWith($key, "_search") || endsWith($key, "_color") || endsWith($key, "_search_retargeting")) {
            $search  = true;
            $display = false;
        }

        if (!$entities || count($entities) == 0) {
            if (!$budgetId) {
                $budgetAmount = isset($cron_config['budget']) ? $cron_config['budget'] : 2.0;
                $budgetName   = $cron_name . ' #' . time();
                slecho("Info: Creating budget with budget name " . $budgetName);
                $budgetId = $service->CreateBudget($budgetName, $budgetAmount);

                if ($budgetId) {
                    slecho("Info: New budgetId is " . $budgetId);
                }
            }

            if (!$budgetId) {
                slecho('ERROR: Unable to create budget for campaign ' . $campaign_name);
                continue;
            }

            secho("Info: Creating new campaign with campaign name " . $campaign_name);
            $cid = $service->CreateCampaign($campaign_name, $budgetId, $search, $display);

            if ($cid) {
                $campaignIds[$key] = $cid;
            } else {
                slecho('ERROR: Unable to create campaign with campaign name ' . $campaign_name);
                continue;
            }
        } else {
            $campaignIds[$key] = $entities[0]->id;
        }

        secho($key . ' CampaignId is: ' . $campaignIds[$key] . '<br/><br/>');
    }

    if (count($campaignIds) == 0) {
        slecho('ERROR: No valid campaign found');
        return;
    }

	slecho("Campaigns: " . json_encode($campaignIds));

    // first I will get the combination userlist id
    $combined_userlist_id = $db_connect->retrive_combined_userlist();

    if (!$combined_userlist_id) {
        // creates a userlist
        $result       = $service->CreateUserList("Rest of the Website Users");
        $userListId   = $result->id;
        $conversionId = $result->conversionTypes[0]->id;
        $result2      = $service->GetConversionTracker($conversionId);
        $codes        = $result2[0]->snippet;

        slecho("Combined Userlist Conversion Tracking Code: ");
        logme_nostrip($codes);

        $match = null;

        preg_match('/var google_conversion_id ?= ?(?<conversion_id>[0-9]+);\s*var google_conversion_label ?= ?"(?<label>[^"]+)"/', $codes, $match);

        if ($match) {
            // deafult
            $db_connect->store_adwords_tag($cron_config['host_url'], '', '', '', $match['conversion_id'], $match['label'], $userListId);
        }

        // now create the common audiance
        $result3 = $service->CreateCombinedUserList("All Users of Website", $userListId);

        if ($result3) {
            $combined_userlist_id = $result3->id;
            $db_connect->store_combined_userlist($combined_userlist_id);
        }
    }

    secho("Unhandled Car Records in DB: " . count($cars_db) . "<br><br>");

    // handle bid modifier
    if (isset($cron_config['bid_modifier'])) {
        $new_bid = isset($cron_config['bid_modifier']['bid']) ? $cron_config['bid_modifier']['bid'] : 2.0;
        $after   = isset($cron_config['bid_modifier']['after']) ? $cron_config['bid_modifier']['after'] : 45;

        slecho('Info: Bid modifier will set CPC bid to $' . $new_bid . ' for ads older than ' . $after . ' days');

        $after_secs   = $after * 86400;
        $current_time = time();

        foreach ($ads_db as $ad_group_id => $ad_details) {
            if ($current_time - $ad_details['created_at'] > $after_secs) {
                $service->UpdateAdGroupBid($ad_group_id, $new_bid);
                slecho('Info: Updating CPC bid for adGroup ' . $ad_group_id);
            }
        }
    } else {
        slecho('Info: No bid modifier in operation');
    }

    ProcessPriceDrop($cars_db, $cron_config);

    try {
        foreach ($cars_db as $stock_number => $car) {
            slecho('Info: handling car ' . $stock_number . ' of ' . $cron_name);

            // delete here if deleted or updated
            if ($car["handled_at"] > 0) {
                slecho('Info: looking to remove old car with stock id ' . $stock_number);

                foreach ($campaignIds as $key => $campaign_id) {
                    // $campaign_name = $cron_config['campaigns'][$key];
                    $ad_group_name = get_ad_group_name($car, $cron_config);
                    $adGroup       = $service->GetAdGroupByCampaignId($campaign_id, $ad_group_name);

                    if ($adGroup && count($adGroup) > 0) {
						slecho('Clearing ad group ' . json_encode($adGroup[0]));
                        clear_ad_group($service, $adGroup[0]->id);
                    }
                }

            }

            $db_connect->update_handled($stock_number); // mark the record as handled

            if ($car['deleted'] == 1) {
                slecho('Info: Car is deleted');
                continue; // if deleted then ignore creating ad and continue to new next record
            }

            // Price update for tax
            $tax = isset($cron_config['tax']) ? $cron_config['tax'] : 0;

            $price        = numarifyPrice($car['price']);
            $tax_amount   = ($price * $tax) / 100;
            $car['price'] = butifyPrice($price + $tax_amount);
            $car['hst']   = $hst;

            if ($hst) {
                $car['banner_price'] = $car['price'];
                $car['price']        = ""; # hide price
            }

            // mazda mod;
            $car['model'] = str_replace('mazda', '', $car['model']);
            $car['model'] = str_replace('Mazda', '', $car['model']);
            $car['model'] = str_replace($car['make'], '', $car['model']);

            // NEW PRICE
            if (isset($cron_config['new_cars'][$car['year'] . ' ' . $car['make'] . ' ' . $car['model']])) {
                $car['price'] = $cron_config['new_cars'][$car['year'] . ' ' . $car['make'] . ' ' . $car['model']];
            }

            $stock_type             = $car['stock_type'];
            $search_key             = $stock_type . '_search';
            $placement_key          = $stock_type . '_placement';
            $display_key            = $stock_type . '_display';
            $retargeting_key        = $stock_type . '_retargeting';
            $search_retargeting_key = $stock_type . '_search_retargeting';
            $marketbuyers_key       = $stock_type . '_marketbuyers';
            $combined_key           = $stock_type . '_combined';
            $color_key              = $stock_type . '_color';

            $searchCampaignId            = isset($campaignIds[$search_key]) ? $campaignIds[$search_key] : false;
            $placementCampaignId         = isset($campaignIds[$placement_key]) ? $campaignIds[$placement_key] : false;
            $displayCampaignId           = isset($campaignIds[$display_key]) ? $campaignIds[$display_key] : false;
            $retargetingCampaignId       = isset($campaignIds[$retargeting_key]) ? $campaignIds[$retargeting_key] : false;
            $searchRetargetingCampaignId = isset($campaignIds[$search_retargeting_key]) ? $campaignIds[$search_retargeting_key] : false;
            $marketbuyersCampaignId      = isset($campaignIds[$marketbuyers_key]) ? $campaignIds[$marketbuyers_key] : false;
            $combinedCampaignId          = isset($campaignIds[$combined_key]) ? $campaignIds[$combined_key] : false;
            $colorCampaignId             = isset($campaignIds[$color_key]) ? $campaignIds[$color_key] : false;

            $create_search             = isset($cron_config['create'][$search_key]) ? $cron_config['create'][$search_key] : false;
            $create_placement          = isset($cron_config['create'][$placement_key]) ? $cron_config['create'][$placement_key] : false;
            $create_display            = isset($cron_config['create'][$display_key]) ? $cron_config['create'][$display_key] : false;
            $create_retargeting        = isset($cron_config['create'][$retargeting_key]) ? $cron_config['create'][$retargeting_key] : false;
            $create_search_retargeting = isset($cron_config['create'][$search_retargeting_key]) ? $cron_config['create'][$search_retargeting_key] : false;
            $create_marketbuyers       = isset($cron_config['create'][$marketbuyers_key]) ? $cron_config['create'][$marketbuyers_key] : false;
            $create_combined           = isset($cron_config['create'][$combined_key]) ? $cron_config['create'][$combined_key] : false;
            $create_color              = isset($cron_config['create'][$color_key]) ? $cron_config['create'][$color_key] : false;

            $default_bid = isset($cron_config['bid']) ? $cron_config['bid'] : 4.0;

            if ($searchCampaignId && $create_search) {
                $txtres = createTextAd(
                    $service,
                    $cron_name,
                    $cron_config,
                    $car,
                    $searchCampaignId,
                    $cron_config['campaigns'][$search_key],
                    $default_bid
                );
            } else {
                slecho('Info: Skipping search ad creation as per configuration');
            }

            if ($colorCampaignId && $create_color) {
                createColorAd(
                    $service,
                    $cron_name,
                    $cron_config,
                    $car,
                    $colorCampaignId,
                    $cron_config['campaigns'][$color_key],
                    $default_bid
                );
            } else {
                slecho('Info: Skipping color ad creation as per configuration');
            }

            if (-1 == $txtres) {
                slecho('Warning: Title too long');
                continue;
            }

            $min_pics = isset($cron_config['banner']['min_pics']) ? $cron_config['banner']['min_pics'] : 0;

            if (count($car['images']) < $min_pics) {
                slecho("Minimum $min_pics are required to create ad");
                continue;
            }

            // create an userlist
            $tag = $db_connect->retrive_tag($car["year"], $car["make"], $car["model"]);

            if (!$tag) {
                $userListName = $cron_name . " - " . $car["year"] . " " . $car['make'] . " " . $car["model"];
                $result       = $service->CreateUserList($userListName);
                $userListId   = $result->id;
                $conversionId = $result->conversionTypes[0]->id;
                $result2      = $service->GetConversionTracker($conversionId);
                $codes        = $result2[0]->snippet;

                slecho("Conversion Tracking Code: ");
                logme_nostrip($codes);

                $match = null;
                preg_match('/var google_conversion_id ?= ?(?<conversion_id>[0-9]+);\s*var google_conversion_label ?= ?"(?<label>[^"]+)"/', $codes, $match);

                if ($match) {
                    // store for url
                    $db_connect->store_adwords_tag(
                        $car["url"],
                        $car["year"],
                        $car["make"],
                        $car["model"],
                        $match['conversion_id'],
                        $match['label'],
                        $userListId
                    );

                    slecho(
                        "Info: New retargetting tag created conversion_id : "
                        . $match['conversion_id'] . " and label : " . $match['label']
                    );
                } else {
                    slecho('Error: Unable to get conversion id');
                }

                // now update the common audience
                $service->AppendCombinedUserList($combined_userlist_id, $userListId);
            } else {
                $userListId = $tag['userlist_id'];
                slecho("Conversion tracking tag:");
                logme_nostrip(json_encode($tag));
            }

            if ($displayCampaignId && $create_display) {
                if (!count($car['images'])) {
                    slecho('Error: Car data did NOT contain any images');
                } else {
                    createBannerWithText(
                        $service,
                        $db_connect,
                        $cron_name,
                        $cron_config,
                        $car,
                        $displayCampaignId,
                        $cron_config['campaigns'][$display_key],
                        'display',
                        $SWFConfigs,
                        $BannerConfigs,
                        null,
                        $default_bid
                    );
                }
            } else {
                slecho('Info: Skipping display ad creation as per configuration');
            }

            if ($placementCampaignId && $create_placement) {
                if (!count($car['images'])) {
                    slecho('Error: Car data did NOT contain any images');
                } else {
                    createBannerWithText(
                        $service,
                        $db_connect,
                        $cron_name,
                        $cron_config,
                        $car,
                        $placementCampaignId,
                        $cron_config['campaigns'][$placement_key],
                        'placement',
                        $SWFConfigs,
                        $BannerConfigs,
                        null,
                        $default_bid
                    );
                }
            } else {
                slecho('Info: Skipping placement ad creation as per configuration');
            }

            if ($searchRetargetingCampaignId && $create_search_retargeting) {
                createRetargetingAd(
                    $service,
                    $cron_name,
                    $cron_config,
                    $car,
                    $searchRetargetingCampaignId,
                    $cron_config['campaigns'][$search_retargeting_key],
                    $default_bid,
                    $userListId
                );
            } else {
                slecho('Info: Skipping search retargeting ad creation as per configuration');
            }

            if ($retargetingCampaignId && $create_retargeting) {
                if (!count($car['images'])) {
                    slecho('Error: Car data did NOT contain any images, check regular expressions, debug: ');
                } else {
                    createBannerWithText(
                        $service,
                        $db_connect,
                        $cron_name,
                        $cron_config,
                        $car,
                        $retargetingCampaignId,
                        $cron_config['campaigns'][$retargeting_key],
                        'retargeting',
                        $SWFConfigs,
                        $BannerConfigs,
                        $userListId,
                        $default_bid
                    );
                }
            } else {
                slecho('Info: Skipping retargeting ad creation as per configuration');
            }

            if (($marketbuyersCampaignId && $create_marketbuyers) || ($combinedCampaignId && $create_combined)) {
                // get user interests here
                $userInterests  = [];
                $interest_count = 0;

                if (isset($market_buyers[$car['make']])) {
                    $makewise = $market_buyers[$car['make']];

                    foreach ($makewise['common'] as $userInterest) {
                        $userInterests[$interest_count] = $userInterest;
                        $interest_count++;
                    }

                    if (isset($makewise[$car['model']])) {
                        $modelwise = $makewise[$car['model']];

                        foreach ($modelwise['common'] as $userInterest) {
                            $userInterests[$interest_count] = $userInterest;
                            $interest_count++;
                        }
                    }
                } else {
                    slecho("Make interest not found Car Make: '" . $car['make'] . "'");
                }

                if (isset($cron_config['market_buyers'])) {
                    $config_buyers = $cron_config['market_buyers'];

                    if (isset($config_buyers['common'])) {
                        foreach ($config_buyers['common'] as $userInterest) {
                            $userInterests[$interest_count] = $userInterest;
                            $interest_count++;
                        }
                    }

                    if ('new' === $stock_type && isset($config_buyers['new'])) {
                        foreach ($config_buyers['new'] as $userInterest) {
                            $userInterests[$interest_count] = $userInterest;
                            $interest_count++;
                        }
                    }

                    if ('used' === $stock_type && isset($config_buyers['used'])) {
                        foreach ($config_buyers['used'] as $userInterest) {
                            $userInterests[$interest_count] = $userInterest;
                            $interest_count++;
                        }
                    }
                }
            }

            if ($userInterests && count($userInterests) > 0) {
                slecho('Info: settign up ' . count($userInterests) . ' user interests');

                if ($marketbuyersCampaignId && $create_marketbuyers) {
                    // here we also need market buyers interest ids
                    if (!count($car['images'])) {
                        slecho('Error: Car data did NOT contain any images, check regular expressions, debug: ');
                    } else {
                        createBannerWithText(
                            $service,
                            $db_connect,
                            $cron_name,
                            $cron_config,
                            $car,
                            $marketbuyersCampaignId,
                            $cron_config['campaigns'][$marketbuyers_key],
                            'marketbuyers',
                            $SWFConfigs,
                            $BannerConfigs,
                            null,
                            $default_bid,
                            $userInterests
                        );
                    }
                } else {
                    slecho('Info: Skipping marketbuyers ad creation as per configuration');
                }
            } else {
                slecho('Info: There was no user interest specified for the car');
            }

            if ($combinedCampaignId && $create_combined) {
                if (!count($car['images'])) {
                    slecho('Error: Car data did NOT contain any images, check regular expressions, debug: ');
                } else {
                    createBannerWithText(
                        $service,
                        $db_connect,
                        $cron_name,
                        $cron_config,
                        $car,
                        $combinedCampaignId,
                        $cron_config['campaigns'][$combined_key],
                        'combined',
                        $SWFConfigs,
                        $BannerConfigs,
                        null,
                        $default_bid,
                        null
                    );
                }
            } else {
                slecho('Info: Skipping combined ad creation as per configuration');
            }
        }
    } catch (Exception $ex) {
        slecho("Exception: " . $ex->getMessage());
    }

    /*
     * Per vehicle cost monitoring
     * Stop ad spend on vehicles that pass a certain monthly threshhold
     */
    if (isset($cron_config['per_vehicle_max_cost']) && ($cron_config['per_vehicle_max_cost'])) {
        MonitorVehicleCost($cron_name, $cron_config, $CurrentConfig, $developer_token, $all_cars_db);
    }

    slecho('Info: Sync complete for cron ' . $cron_name);
}

/**
 * { function_description }
 *
 * @param      AdwordsService  $service      The service
 * @param      <type>          $cars_db      The cars database
 * @param      <type>          $ads_db       The ads database
 * @param      <type>          $all_cars_db  All cars database
 * @param      <type>          $smart_ad     The smart ad
 * @param      DbConnect       $db_connect   The database connect
 * @param      <type>          $cron_config  The cron configuration
 */
function ProcessSmartAds(AdwordsService $service, &$cars_db, $ads_db, $all_cars_db, $smart_ad, DbConnect $db_connect, $cron_config)
{
    if (count($cars_db) == 0) {
        return;
    }

    slecho('Calculating smart ad params');
    slecho('Total cars in db: ' . count($all_cars_db));

    $temp = [];

    // similarly also find just make+model counts, no year though, this is for the [mmcount] stock count tag
    $mmcount_r  = [];
    $ymmcount_r = [];

    // Find cheapest year+make+model car available from similar year+make+model cars
    foreach ($all_cars_db as $stock_number => $car) {
        // @TODO is this a problem for F-150, F-300?
        $key    = $car['year'] . '-' . $car['make'] . '-' . $car['model'];
        $mmkey  = $car['make'] . '-' . $car['model'];
        $ymmkey = $car['year'] . '-' . $car['make'] . '-' . $car['model'];

        if (numarifyPrice($car['price']) == 0) {
            slecho('Info: Smart URL skips cars with invalid price. car ' . $key);
            continue;
        }

        if (isset($temp[$key])) {
            $temp[$key]['stock_numbers'][$temp[$key]['count']] = $stock_number;
            $temp[$key]['count']                               = $temp[$key]['count'] + 1;

            if (numarifyPrice($car['price']) < $temp[$key]['price']) {
                $temp[$key]['price'] = numarifyPrice($car['price']);
            }
        } else {
            $temp[$key] = array(
                'price'         => numarifyPrice($car['price']),
                'count'         => 1,
                'stock_numbers' => array($stock_number),
            );
        }

        if (!array_key_exists($mmkey, $mmcount_r)) {
            $mmcount_r[$mmkey] = 1;
        } else {
            $mmcount_r[$mmkey]++;
        }

        if (!array_key_exists($ymmkey, $ymmcount_r)) {
            $ymmcount_r[$ymmkey] = 1;
        } else {
            $ymmcount_r[$ymmkey]++;
        }
    }

    // might be redundant but better safe...
    foreach ($cars_db as $stock_number => $car) {
        $cars_db[$stock_number]['mmcount']  = $mmcount_r[$car['make'] . '-' . $car['model']];
        $cars_db[$stock_number]['ymmcount'] = $ymmcount_r[$car['year'] . '-' . $car['make'] . '-' . $car['model']];
    }

    foreach ($all_cars_db as $stock_number => $car) {
        $all_cars_db[$stock_number]['mmcount']  = $mmcount_r[$car['make'] . '-' . $car['model']];
        $all_cars_db[$stock_number]['ymmcount'] = $ymmcount_r[$car['year'] . '-' . $car['make'] . '-' . $car['model']];
    }

    // Manipulate
    foreach ($temp as $key => $group) {
        if ($group['count'] <= 1) {
            continue;
        }

        $group_size = count($group['stock_numbers']);
        slecho("Info: Selecting 1 vehicle for $key from within $group_size");
        $ad_created = false;

        foreach ($group['stock_numbers'] as $stock_number) {
            $price = numarifyPrice($all_cars_db[$stock_number]['price']);

            if ($price > $group['price']) {
                // delete ad if exist [Lagacy support revoked, we may need to think about new approach]
                if (isset($cars_db[$stock_number])) {
                    // only create retargeting
                    $regular_url                           = $cars_db[$stock_number]['url'];
                    $cars_db[$stock_number]['url']         = '';
                    $cars_db[$stock_number]['regular_url'] = $regular_url;
                }
            } else {
                if (!$ad_created) {

                    $car = $all_cars_db[$stock_number];

                    if ($smart_ad) {
                        $url = str_replace(
                            array('[stock_type]', '[year]', '[make]', '[model]'),
                            array($car['stock_type'], $car['year'], $car['make'], $car['model']),
                            $smart_ad
                        );
                    } else {
                        $url = $car['url'];
                    }

                    $regular_url            = $car['url'];
                    $car['url']             = $url;
                    $car['regular_url']     = $regular_url;
                    $cars_db[$stock_number] = $car;
                    $ad_created             = true;
                    slecho('Info: selected ' . $group['stock_type'] . ' car with price ' . butifyPrice($group['price']) . ' for ' . $key);
                } else {
                    $car           = $all_cars_db[$stock_number];
                    $ad_group_name = get_ad_group_name($car, $cron_config);

                    foreach ($cron_config['campaigns'] as $key => $campaign_name) {
                        $adGroup = $service->GetAdGroup($campaign_name, $ad_group_name);

                        if ($adGroup && count($adGroup) > 0) {
                            clear_ad_group($service, $adGroup[0]->id);
                        }
                    }

                    if (isset($cars_db[$stock_number])) {
                        // only create retargeting
                        $regular_url                           = $cars_db[$stock_number]['url'];
                        $cars_db[$stock_number]['url']         = '';
                        $cars_db[$stock_number]['regular_url'] = $regular_url;
                    }
                }
            }
        }
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $cars_db      The cars database
 * @param      <type>  $cron_config  The cron configuration
 */
function ProcessPriceDrop(&$cars_db, $cron_config)
{
    foreach ($cars_db as $stock_number => $car) {
        $price_history = $car['price_history'];

        if (count($price_history) > 1) {
            $keys       = array_keys($price_history);
            $initial    = numarifyPrice($price_history[$keys[0]]);
            $current    = numarifyPrice($price_history[$keys[count($keys) - 1]]);
            $droppedby  = $initial - $current;
            $percentage = ($droppedby / $initial) * 100;
            $key        = $car['stock_type'] . '_pricedrop';

            if ($percentage > 10 && isset($cron_config['banner']['styels'][$key])) {
                $cars_db[$stock_number]['droppedby'] = butifyPrice($droppedby);
            }
        }
    }
}

/**
 * { function_description }
 *
 * @param      string  $cron_name    The cron name
 * @param      <type>  $cron_config  The cron configuration
 * @param      bool    $force        The force
 */
function ClearAds($cron_name, $cron_config, $force = false)
{
    global $CurrentConfig, $developer_token;

    $elements2 = ['special', 'new', 'used', 'device', 'accessory'];
    $elements3 = array(
        'search',
        'combined',
        'search_remarketing',
        'retargeting',
        'remarketing',
        'marketbuyers',
        'image',
        'display',
        'color',
        'placement',
    );

    $del_campaigns = [];

    foreach ($elements2 as $element2) {
        foreach ($elements3 as $element3) {
            $del_campaigns[] = strtolower($cron_name . '_' . $element2 . '_' . $element3);
        }
    }

    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $cron_config['customer_id']
    );

    $campaigns = $service->GetCampaigns();

    foreach ($campaigns as $campaign) {
        if (!in_array(strtolower($campaign->name), $del_campaigns)) {
            continue;
        }

        slecho('Clearing adgroups in ' . $campaign->name);

        $adgroups = $service->GetAdGroups($campaign->name);

        if (!$adgroups) {
            continue;
        }

        foreach ($adgroups as $adgroup) {
            slecho('Deleting ads from adgroup ' . $adgroup->name);
            $ads = $service->GetAds($adgroup->id);

            if ($ads) {
                $ad_ids = [];

                foreach ($ads as $ad) {
                    $ad_ids[] = $ad->ad->id;
                }

                if (count($ad_ids) > 0) {
                    $service->RemoveAd($adgroup->id, $ad_ids);
                }

                slecho(count($ad_ids) . " ads are deleted");
            }

            slecho('Deleting keywords from adgroup ' . $adgroup->name);
            $keywords = $service->GetKeywords($adgroup->id);

            if ($keywords) {
                $keyword_ids = [];

                foreach ($keywords as $keyword) {
                    $keyword_ids[] = $keyword->criterion->id;
                }

                if (count($keyword_ids) > 0) {
                    $service->RemoveKeyword($adgroup->id, $keyword_ids);
                }

                slecho(count($keyword_ids) . " keywords are deleted");
            }

            slecho('Deleting placements from adgroup ' . $adgroup->name);
            $placements = $service->GetAdGroupPlacements($adgroup->id);

            if ($placements) {
                $placement_ids = [];

                foreach ($placements as $placement) {
                    $placement_ids[] = $placement->criterion->id;
                }

                if (count($placement_ids) > 0) {
                    $service->RemoveAdGroupPlacements($adgroup->id, $placement_ids);
                }

                slecho(count($placement_ids) . " placements are deleted");
            }

            $service->SetAdGroupStatus($adgroup->id, false);
        }
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $con          The con
 * @param      <type>  $cron_name    The cron name
 * @param      <type>  $cron_config  The cron configuration
 * @param      <type>  $mutex        The mutex
 */
function FilterKeywords($con, $cron_name, $cron_config, $mutex)
{
    global $CurrentConfig, $developer_token;

    $cars_db     = [];
    $ads_db      = [];
    $all_cars_db = [];

    $db_connect = new DbConnect($cron_name);
    $db_connect->LoadCarAds($cars_db, $ads_db, $all_cars_db, $cron_config);
    $service = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);

    foreach ($ads_db as $adGroupId => $ad_details) {
        $keywords = $service->GetKeywords($adGroupId);

        if (!$keywords) {
            continue;
        }

        foreach ($keywords as $keyword) {
            $keyword_text  = $keyword->criterion->text;
            $quality_score = $keyword->qualityInfo->qualityScore;
            $keywordId     = $keyword->criterion->id;
            slecho("Info: Keyword '" . $keyword_text . "' Quality score " . $quality_score);

            if ($quality_score > 0 && $quality_score < 5) {
                slecho("Info: Pausing Keyword. Quality score is less than 5");
                $result = $service->PauseKeyword($adGroupId, $keywordId);

                if (!$result) {
                    slecho("Warning: Unable to change keyword status");
                }
            }
        }

        $ad_details = null;
        slecho("");
    }

    // Now deal with impression and ctr (Pause rules)
    $search_min_impression       = isset($cron_config['keyword_filter']['search']['min_impression']) ? $cron_config['keyword_filter']['search']['min_impression'] : 200;
    $search_max_ctr              = isset($cron_config['keyword_filter']['search']['max_ctr']) ? $cron_config['keyword_filter']['search']['max_ctr'] : 0.80;
    $search_pause_min_impression = isset($cron_config['keyword_filter']['search']['pause_min_impression']) ? $cron_config['keyword_filter']['search']['pause_min_impression'] : 400;
    $search_pause_max_ctr        = isset($cron_config['keyword_filter']['search']['pause_max_ctr']) ? $cron_config['keyword_filter']['search']['pause_max_ctr'] : 0.80;
    $display_min_impression      = isset($cron_config['keyword_filter']['display']['min_impression']) ? $cron_config['keyword_filter']['display']['min_impression'] : 200;
    $display_max_ctr             = isset($cron_config['keyword_filter']['display']['max_ctr']) ? $cron_config['keyword_filter']['display']['max_ctr'] : 0.20;
    slecho('Info: Processing Keywords for search network. Min Impression: ' . $search_min_impression . ' Max Ctr: ' . $search_max_ctr . '%');

    // set match type to 'exact'
    $search_keywords = $service->GetKeywordPerformance('SEARCH', $search_min_impression, $search_max_ctr);

    foreach ($search_keywords as $keyword) {
        ProcessKeyword($service, $cron_name, $keyword, $search_max_ctr, false);
    }

    // pause search keywords
    $search_pause_keywords = $service->GetKeywordPerformance('SEARCH', $search_pause_min_impression, $search_pause_max_ctr);

    foreach ($search_pause_keywords as $keyword) {
        ProcessKeyword($service, $cron_name, $keyword, $search_max_ctr, true);
    }

    slecho('Info: Processing Keywords for display network. Min Impression: ' . $display_min_impression . ' Max Ctr: ' . $display_max_ctr . '%');

    // pause display keywords
    $display_keywords = $service->GetKeywordPerformance('CONTENT', $display_min_impression, $display_max_ctr);

    foreach ($display_keywords as $keyword) {
        ProcessKeyword($service, $cron_name, $keyword, $search_max_ctr, true);
    }

    slecho('');
}

// if pause = false then it will change match type to exact
/**
 * { function_description }
 *
 * @param      AdwordsService  $service    The service
 * @param      string          $cron_name  The cron name
 * @param      <type>          $keyword    The keyword
 * @param      integer         $max_ctr    The maximum counter
 * @param      boolean         $pause      The pause
 */
function ProcessKeyword(AdwordsService $service, $cron_name, $keyword, $max_ctr, $pause = true)
{
    if (startsWith($keyword['Campaign'], $cron_name . '_') && $keyword['Keyword ID'] != 'Total' && $keyword['Keyword'] != 'Content') {
        $ctr = floatval($keyword['CTR']);

        if ($ctr < $max_ctr) {
            if ($pause) {
                slecho('Info: Pausing Keyword ' . $keyword['Keyword'] . ' Impression: ' . $keyword['Impressions'] . ' Ctr: ' . $keyword['CTR']);
                $service->PauseKeyword($keyword['Ad group ID'], $keyword['Keyword ID']);
            } else {
                slecho('Info: Changing match type to exact for Keyword ' . $keyword['Keyword'] . ' Impression: ' . $keyword['Impressions'] . ' Ctr: ' . $keyword['CTR']);
                $service->SetMatchType($keyword['Ad group ID'], $keyword['Keyword ID'], 'EXACT');
            }
        }
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $cron_name    The cron name
 * @param      <type>  $cron_config  The cron configuration
 */
function FilterAdGroups($cron_name, $cron_config)
{
    global $CurrentConfig, $developer_token;

    $service                = new AdwordsService(Consts::ServiceNamespace, $CurrentConfig, $developer_token, $cron_config['customer_id']);
    $search_min_impression  = isset($cron_config['adgroup_filter']['search']['min_impression']) ? $cron_config['adgroup_filter']['search']['min_impression'] : 700;
    $search_max_ctr         = isset($cron_config['adgroup_filter']['search']['max_ctr']) ? $cron_config['adgroup_filter']['search']['max_ctr'] : 0.80;
    $display_min_impression = isset($cron_config['adgroup_filter']['display']['min_impression']) ? $cron_config['adgroup_filter']['display']['min_impression'] : 700;
    $display_max_ctr        = isset($cron_config['adgroup_filter']['display']['max_ctr']) ? $cron_config['adgroup_filter']['display']['max_ctr'] : 0.20;

    if ($search_min_impression !== false && $search_max_ctr !== false) {
        slecho('Info: Processing AdGroups for search network. Min Impression: ' . $search_min_impression . ' Max Ctr: ' . $search_max_ctr . '%');
        $searchAdGroups = $service->GetAdGroupPerformance("SEARCH", $search_min_impression, $search_max_ctr);

        foreach ($searchAdGroups as $adGroup) {
            ProcessAdGroup($service, $cron_name, $adGroup, $search_max_ctr);
        }
    } else {
        slecho('Info: Skiping AdGroup filter for search network, filter not defined for ' . $cron_name);
    }

    if ($display_min_impression !== false && $display_max_ctr !== false) {
        slecho('Info: Processng AdGroups for display network. Min Impression: ' . $display_min_impression . ' Max Ctr: ' . $display_max_ctr . '%');
        $displayAdGroups = $service->GetAdGroupPerformance("CONTENT", $display_min_impression, $display_max_ctr);

        foreach ($displayAdGroups as $adGroup) {
            ProcessAdGroup($service, $cron_name, $adGroup, $display_max_ctr);
        }
    } else {
        slecho('Info: Skiping AdGroup filter for display network, filter not defined for ' . $cron_name);
    }

    slecho("");
}

/**
 * { function_description }
 *
 * @param      <type>   $service    The service
 * @param      string   $cron_name  The cron name
 * @param      <type>   $adGroup    The ad group
 * @param      integer  $max_ctr    The maximum counter
 */
function ProcessAdGroup($service, $cron_name, $adGroup, $max_ctr)
{
    if (startsWith($adGroup['Campaign'], $cron_name . '_') && $adGroup['Ad group ID'] != 'Total') {
        $ctr = floatval($adGroup['CTR']);

        if ($ctr < $max_ctr) {
            slecho(
                'Info: Pausing Adgroup ' . $adGroup['Ad group']
                . ' Impression: ' . $adGroup['Impressions']
                . ' Ctr: ' . $adGroup['CTR']
            );

            $service->SetAdGroupStatus($adGroup['Ad group ID'], false);
        }
    }
}

/**
 * { function_description }
 *
 * @param      AdwordsService  $service      The service
 * @param      string          $cron_name    The cron name
 * @param      <type>          $cron_config  The cron configuration
 */
function MonitorAccountCost(AdwordsService $service, $cron_name, $cron_config)
{
    if (!isset($cron_config['max_cost'])) {
        slecho('Warning: cost monitor: No max_cost is set. Skipping account monitor');
        return;
    }

    $pattern         = $cron_name . '_';
    $pattern2        = 'smedia_' . $pattern;
    $new_pattern     = '_new';
    $used_pattern    = '_used';
    $youtube_pattern = '_youtube';

    $on15      = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $campaigns = $service->GetAccountCost($on15);
    $max_cost  = $cron_config['max_cost'];

    // @TODO: quick hack fix Remove it later
    if ($on15) {
        $max_cost = $max_cost >> 1;
    }

    $cost_distribution = isset($cron_config['cost_distribution']) ? $cron_config['cost_distribution'] : false;
    $handle_youtube    = false;
    $handle_either     = false;

    if ($cost_distribution) {
        $handle_youtube = isset($cost_distribution['youtube']);
        $handle_either  = isset($cost_distribution['adwords']);

        $distribution_total = $cost_distribution['new'] + $cost_distribution['used'];

        if ($handle_youtube) {
            $distribution_total += $cost_distribution['youtube'];
        }

        if ($handle_either) {
            $distribution_total += $cost_distribution['adwords'];
        }

        $max_new_cost  = ($max_cost / $distribution_total) * $cost_distribution['new'];
        $max_used_cost = ($max_cost / $distribution_total) * $cost_distribution['used'];

        if ($handle_either) {
            $max_either_cost = ($max_cost / $distribution_total) * $cost_distribution['adwords'];
        }

        if ($handle_youtube) {
            $max_youtube_cost = ($max_cost / $distribution_total) * $cost_distribution['youtube'];
        }
    }

    $new_cost     = 0.0;
    $used_cost    = 0.0;
    $youtube_cost = 0.0;
    $total_cost   = 0.0;

    foreach ($campaigns as $campaign) {
        if (startsWith($campaign['Campaign'], $pattern) || startsWith($campaign['Campaign'], $pattern2)) {
            $c_cost = round($campaign['Cost'] / 1000000);

            $total_cost += $c_cost;

            if (stripos($campaign['Campaign'], $new_pattern) > 0) {
                $new_cost += $c_cost;
            }

            if (stripos($campaign['Campaign'], $used_pattern) > 0) {
                $used_cost += $c_cost;
            }

            if (stripos($campaign['Campaign'], $youtube_pattern) > 0) {
                $youtube_cost += $c_cost;
            }
        }
    }

    slecho('Info: cost monitor: Max allowed account cost $' . $max_cost);

    if ($cost_distribution) {
        if ($handle_either) {
            slecho('Info: cost monitor: Max allowed cost on adwords campaigns $' . $max_either_cost);
        } else {
            slecho('Info: cost monitor: Max allowed cost on new campaigns $' . $max_new_cost);
            slecho('Info: cost monitor: Max allowed cost on used campaigns $' . $max_used_cost);
        }
        if ($handle_youtube) {
            slecho('Info: cost monitor: Max allowed cost on youtube campaigns $' . $max_youtube_cost);
        }
    }

    if ($handle_either) {
        $nucost = $new_cost + $used_cost;
        slecho('Info: cost monitor: Cost on adword campaigns $' . $nucost);
    } else {
        slecho('Info: cost monitor: Cost on new campaigns $' . $new_cost);
        slecho('Info: cost monitor: Cost on used campaigns $' . $used_cost);
    }

    if ($handle_youtube) {
        slecho('Info: cost monitor: Cost on youtube campaigns $' . $youtube_cost);
    }
    slecho('Info: cost monitor: Total cost on managed campaigns $' . $total_cost);

    foreach ($campaigns as $campaign) {
        if (startsWith($campaign['Campaign'], $pattern) || startsWith($campaign['Campaign'], $pattern2)) {
            $actual_cost = $total_cost;
            $border_cost = $max_cost;

            if ($cost_distribution) {
                if (startsWith($campaign['Campaign'], $new_pattern)) {
                    $actual_cost = $new_cost;
                    $border_cost = $max_new_cost;

                    if ($handle_either) {
                        $actual_cost = $nucost;
                        $border_cost = $max_either_cost;
                    }
                }

                if (startsWith($campaign['Campaign'], $used_pattern)) {
                    $actual_cost = $used_cost;
                    $border_cost = $max_used_cost;

                    if ($handle_either) {
                        $actual_cost = $nucost;
                        $border_cost = $max_either_cost;
                    }
                }

                if ($handle_youtube && startsWith($campaign['Campaign'], $youtube_pattern)) {
                    $actual_cost = $youtube_cost;
                    $border_cost = $max_youtube_cost;
                }
            }

            if (REDUCE_COST == true) {
                if ($campaign['Campaign state'] == 'enabled') {
                    if ($actual_cost > $border_cost || $total_cost > $max_cost) {
                        slecho('Info: cost monitor: setting campaign budget to 0.01 ' . $campaign['Campaign']);
                        setMinCampaignBudget($service, $campaign['Campaign ID'], $campaign['Campaign']);
                    }
                }
            } else {
                if ($actual_cost > $border_cost || $total_cost > $max_cost) {
                    if ($campaign['Campaign state'] == 'enabled') {
                        slecho('Info: cost monitor: Pausing campaign ' . $campaign['Campaign']);
                        $service->SetCampaignStatus($campaign['Campaign ID'], 'PAUSED');
                    } else {
                        slecho('Info: custom cost monitor: Campaign ' . $campaign['Campaign'] . ' should remain paused');
                    }
                } else {
                    if ($campaign['Campaign state'] == 'paused') {
                        slecho('Info: cost monitor: Should activate campaign ' . $campaign['Campaign']);
                        $service->SetCampaignStatus($campaign['Campaign ID'], 'ENABLED');
                    } else {
                        slecho('Info: cost monitor: Campaign ' . $campaign['Campaign'] . ' should remain active');
                    }
                }
            }
        }
    }
}

/**
 * { function_description }
 *
 * @param      string  $cron_name        The cron name
 * @param      <type>  $cron_config      The cron configuration
 * @param      <type>  $CurrentConfig    The current configuration
 * @param      <type>  $developer_token  The developer token
 */
function MonitorCustomAccountCost($cron_name, $cron_config, $CurrentConfig, $developer_token)
{
    if (!isset($cron_config['max_cost'])) {
        slecho('Warning: No max_cost is set. Skipping account monitor');
        return;
    }

    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $cron_config['customer_id']
    );

    $on15  = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $range = isset($cron_config['range']) ? $cron_config['range'] : false;

    if ($range && (strtotime($range['end']) + 86400) < time()) {
        slecho('Monitoring period has expired');
        return;
    }

    $campaigns = $service->GetAccountCost($on15, $range);
    $max_cost  = $cron_config['max_cost'];

    # @TODO: quick hack fix Remove it later
    if ($on15) {
        $max_cost = $max_cost >> 1;
    }

    $cost_distribution = isset($cron_config['cost_distribution']) ? $cron_config['cost_distribution'] : false;

    if ($cost_distribution) {
        $distribution_total = $cost_distribution['custom'] + $cost_distribution['youtube'];
        $max_custom_cost    = ($max_cost / $distribution_total) * $cost_distribution['custom'];
        $max_youtube_cost   = ($max_cost / $distribution_total) * $cost_distribution['youtube'];
    } else {
        $max_custom_cost = $max_cost;
    }

    $custom_cost = 0.0;
    $pattern     = $cron_name . '_';
    $pattern2    = 'smedia_' . $pattern;

    foreach ($campaigns as $campaign) {
        if (startsWith($campaign['Campaign'], $pattern) !== 0 && startsWith($campaign['Campaign'], $pattern2) !== 0) {
            continue;
        }

        if ($campaign['Campaign ID'] == 'Total') {
            continue;
        }

        $c_cost = round($campaign['Cost'] / 1000000);
        $custom_cost += $c_cost;
    }

    slecho('Info: cost monitor custom:  Max allowed account cost $' . $max_cost);

    if ($cost_distribution) {
        slecho('Info: cost monitor custom: Max allowed cost on custom campaigns $' . $max_custom_cost);
        slecho('Info: cost monitor custom: Max allowed cost on youtube campaigns $' . $max_youtube_cost);
    }

    foreach ($campaigns as $campaign) {
        if (startsWith($campaign['Campaign'], $pattern) !== 0 && startsWith($campaign['Campaign'], $pattern2) !== 0) {
            continue;
        }
        if ($campaign['Campaign ID'] == 'Total') {
            continue;
        }

        $actual_cost = $custom_cost;
        $border_cost = $max_custom_cost;

        if (REDUCE_COST == true) {
            if ($campaign['Campaign state'] == 'enabled') {
                if ($actual_cost > $border_cost) {
                    slecho('Info: cost monitor custom: setting campaign budget to 0.01 ' . $campaign['Campaign']);
                    setMinCampaignBudget($service, $campaign['Campaign ID'], $campaign['Campaign']);
                }
            }
        } else {
            if ($actual_cost > $border_cost) {
                if ($campaign['Campaign state'] == 'enabled') {
                    slecho('Info: cost monitor custom: Pausing campaign ' . $campaign['Campaign']);
                    $service->SetCampaignStatus($campaign['Campaign ID'], 'PAUSED');
                } else {
                    slecho('Info: cost monitor custom: Campaign ' . $campaign['Campaign'] . ' should remain paused');
                }
            } else {
                if ($campaign['Campaign state'] == 'paused') {
                    slecho('Info: cost monitor custom: Should activate campaign ' . $campaign['Campaign']);
                    $service->SetCampaignStatus($campaign['Campaign ID'], 'ENABLED');
                } else {
                    slecho('Info: cost monitor custom: Campaign ' . $campaign['Campaign'] . ' should remain active');
                }
            }
        }
    }
}

/**
 * { function_description }
 *
 * @param      <type>  $cron_name        The cron name
 * @param      <type>  $cron_config      The cron configuration
 * @param      <type>  $CurrentConfig    The current configuration
 * @param      <type>  $developer_token  The developer token
 * @param      <type>  $all_cars_db      All cars database
 */
function MonitorVehicleCost($cron_name, $cron_config, $CurrentConfig, $developer_token, $all_cars_db)
{
    slecho('started MonitorVehicleCost');
    $service = new AdwordsService(
        Consts::ServiceNamespace,
        $CurrentConfig,
        $developer_token,
        $cron_config['customer_id']
    );

    $on15                  = isset($cron_config['on15']) ? $cron_config['on15'] : false;
    $range                 = isset($cron_config['range']) ? $cron_config['range'] : false;
    $adgroupCost           = $service->GetAdGroupPerformanceCost($on15, $range);
    $adgroupCumulativeCost = [];

    // Calculate total cost based on ad group name
    foreach ($adgroupCost as $key => $ad_group) {
        $ad_group_name = $ad_group['Ad group'];
        if (isset($adgroupCumulativeCost[$ad_group_name])) {
            $adgroupCumulativeCost[$ad_group_name]['total_cost'] += $ad_group['Cost'];
            $adgroupCumulativeCost[$ad_group_name]['adGroupId'][] = $ad_group['Ad group ID'];
        } else {
            $adgroupCumulativeCost[$ad_group_name]['total_cost']  = $ad_group['Cost'];
            $adgroupCumulativeCost[$ad_group_name]['adGroupId'][] = $ad_group['Ad group ID'];
        }
    }

    /*
     * Go through all_cars_db and check cost for every ad group name
     * If cost is maximum than per vehicle cost, then paused those ad group id
     */
    $per_vehicle_max_cost = $cron_config['per_vehicle_max_cost'];

    foreach ($all_cars_db as $stock_number => $car) {
        $ad_group_name = get_ad_group_name($car, $cron_name);
        if (!isset($adgroupCumulativeCost[$ad_group_name])) {
            continue;
        }

        $ad_group_total_cost = $adgroupCumulativeCost[$ad_group_name]['total_cost'] / 1000000;

        if ($ad_group_total_cost >= $per_vehicle_max_cost) {
            $adGroupIds = $adgroupCumulativeCost[$ad_group_name]['adGroupId'];

            foreach ($adGroupIds as $key => $adGroupId) {
                $service->SetAdGroupStatus($adGroupId, false);
                slecho('Set status PAUSED for adGroupId:' . $adGroupId);
            }
        }
    }
    slecho('end MonitorVehicleCost');
}

/**
 * Set Campaign Budget to 0.01, it will store current budget into
 * campaign_budget meta table, using campaign id as key. So make sure that,
 * campaign_budget meta table exists
 *
 * @param      AdwordsService  $service
 * @param      int|string      $campaign_id    The campaign identifier
 * @param      string          $campaign_name  The campaign name
 */
function setMinCampaignBudget($service, $campaign_id, $campaign_name)
{
    $_budget_info = $service->GetCampaignBudget($campaign_id);
    $budget_info  = is_array($_budget_info) && isset($_budget_info[0]) && isset($_budget_info[0]->budget)
    ? $_budget_info[0]->budget
    : null;

    if ($budget_info) {
        $budget_id      = isset($budget_info->budgetId) ? $budget_info->budgetId : null;
        $budget_ammount = isset($budget_info->amount) && isset($budget_info->amount->microAmount)
        ? $budget_info->amount->microAmount
        : 7000000;

        if ($budget_id) {
            update_meta('campaign_budget', $campaign_id, $budget_ammount / 1000000);
            $service->SetBudget($budget_id, 0.01);
            // SEND EMAIL
            $customer = $service->customer_id;
            $maillist = ['tanvir@smedia.ca', 'umer@smedia.ca'];
            $sender   = 'support@smedia.ca';
            $subject  = "Google ads paused for customer id: <i>{$customer}</i>";
            $message  = "Budget has been set to 0.01 USD due to budget limit ending for campaign: <i><strong>{$campaign_id}</strong></i> of customer id: <i><strong>{$customer}</strong></i> with campaign name: <i><strong>{$campaign_name}</strong></i>";
            SendEmail($maillist, $sender, $subject, $message);
        } else {
            slecho("Budget id not found to reduce budget");
        }
    } else {
        slecho("Budget info not found to reduce budget");
    }
}
