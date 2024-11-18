<?php

require_once dirname(dirname(__DIR__)) . "/sale-prediction/process-redshift/config.php";

function insert_update_overall($cron_name, $featuresData)
{
    if (count($featuresData)) {
        $dealerExist = dealer_exist_in_table('salematrix_overall', $cron_name);
        $current_time = date('Y-m-d H:i:s');

        if ($dealerExist->fetch()) {
            $where['dealership'] = $cron_name;
            $where['calc_type'] = 'mean';

            $featuresData['mean']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_overall', $featuresData['mean'], $where);

            $where['calc_type'] = 'sd';
            $featuresData['sd']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_overall', $featuresData['sd'], $where);

            echo "Sale Matrix Overall Data Updated For " . $cron_name . " <br>";
        } else {
            $featuresData['mean']['dealership'] = $cron_name;
            $featuresData['mean']['calc_type'] = 'mean';
            $featuresData['mean']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_overall', $featuresData['mean']);

            $featuresData['sd']['dealership'] = $cron_name;
            $featuresData['sd']['calc_type'] = 'sd';
            $featuresData['sd']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_overall', $featuresData['sd']);

            echo "Sale Matrix Overall Data Insert For " . $cron_name . " <br>";
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

    /*
     *  Get Features Data Array
     */
    $soldCarUrls    = get_all_sold_car($cron_name);
    $featuresData   = [];

    /*
     *  Loop for pageview
     */
    foreach ($pageViews as $pageview) {

        /*
         * To match url, check with our scraper table sold car data url
         */
        $car_url = url_exit($soldCarUrls, $pageview['url']);

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
            $featuresData[$pageview['url']]['day_to_sale'] = $soldCarUrls[$car_url]['days'];
        }

        /*
         *  Loop for event
         */
        $events = get_all_event($pageview['view_id']);
        foreach ($events as $event_data) {
            if (!empty($event_data)) {
                $featuresData = prepare_feature_data_url($featuresData, $event_data, $pageview['url']);
            }
        }
    }

    /*
     * We ignore any vehicle that has less than 100 pageviews
     * Not enough data
     */
    $featuresData = ignore_small_preview($featuresData);


    /*
     * Prepare car data to calculate mean and sd
     */
    $featuresData = pre_possess_feature_data($featuresData);


    /*
     * Finally calculation of mean and sd in total
     */
    $featuresData = cal_mean_sd($featuresData);

    /*
     * Insert/Update mean and sd data into sale matrix overall table
     */
    insert_update_overall($cron_name, $featuresData);
}


