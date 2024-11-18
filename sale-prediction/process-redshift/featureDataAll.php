<?php

require_once dirname(dirname(__DIR__)) . "/sale-prediction/process-redshift/config.php";

function insert_update_feature_data_all($cron_name, $featuresData)
{
    if (count($featuresData)) {
        $current_time = date('Y-m-d H:i:s');

        foreach ($featuresData as $url => $urlData) {
            $dealerExist = url_exist_in_table('salematrix_featuredata_all', $cron_name, $url);

            if ($dealerExist->fetch()) {
                $where['dealership'] = $cron_name;
                $where['url'] = $url;

                $urlData['last_updated'] = $current_time;
                ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_featuredata_all', $urlData, $where);

                echo "Sale Matrix Feature Data All Update For " . $cron_name . " And URL : " . $url . " <br>";
            } else {
                $urlData['dealership'] = $cron_name;
                $urlData['url'] = $url;
                $urlData['last_updated'] = $current_time;
                ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_featuredata_all', $urlData);

                echo "Sale Matrix Feature Data All Insert For " . $cron_name . " And URL : " . $url . " <br>";
            }
        }
    }
}

/*
 * Get All dealer and website Url
 */

$get_dealer = filter_input(INPUT_GET, 'dealership');

if ($get_dealer) {
    $all_active_dealers = get_all_dealer($get_dealer);
} else {
    $all_active_dealers = get_all_dealer();
}

foreach ($all_active_dealers as $cron_name => $website) {

    $pageViews = get_all_page_view($website);

    $last15Days = time() - 7 * 24 * 3600;
    $pageViews  = get_all_page_view($website, ' < ' . $last15Days);

    /*
     *  Get All Car Data Array
     */
    $allCarUrls     = get_all_car($cron_name);
    $featuresData   = [];

    /*
     *  Loop for pageview
     */
    foreach ($pageViews as $pageview) {

        /*
         * To match url, check with our scraper table sold car data url
         */
        $car_url = url_exit($allCarUrls, $pageview['url']);

        /*
         * Skip if not in sold car list
         */
        if (!$car_url) {
            continue;
        }

        /*
        * initialize every url with every events
        */
        if (!isset($featuresData[$pageview['url']])) {
            $featuresData = feature_data_url($featuresData, $pageview['url']);
            $featuresData[$pageview['url']]['time_on_inventory'] = $allCarUrls[$car_url]['days'];
            $featuresData[$pageview['url']]['deleted'] = $allCarUrls[$car_url]['deleted'];
        }


        $events = get_all_event($pageview['view_id']);
        if (count($events)) {
            foreach ($events as $event_data) {
                if (!empty($event_data)) {
                    $featuresData = prepare_feature_data_url($featuresData, $event_data, $pageview['url']);
                }
            }
        }
    }

    /*
     * Insert/Update mean and sd data into sale matrix feature data all table
     */
    insert_update_feature_data_all($cron_name, $featuresData);
}


