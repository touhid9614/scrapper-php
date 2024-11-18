<?php

require_once dirname(dirname(__DIR__)) . "/sale-prediction/process-redshift/config.php";

function insert_update_page_view($cron_name, $featuresData)
{
    if (count($featuresData)) {
        $dealerExist = dealer_exist_in_table('salematrix_pageview', $cron_name);
        $current_time = date('Y-m-d H:i:s');

        if ($dealerExist->fetch()) {
            $where['dealership'] = $cron_name;

            $featuresData['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_pageview', $featuresData, $where);

            echo "Sale Matrix Page View Data Updated For " . $cron_name . " <br>";
        } else {
            $featuresData['dealership'] = $cron_name;
            $featuresData['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_pageview', $featuresData);

            echo "Sale Matrix Page View Data Insert For " . $cron_name . " <br>";
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
    $featuresData = feature_data();

    /*
     *  Loop for pageview
     */
    foreach ($pageViews as $pageview) {
        $events = get_all_event($pageview['view_id']);
        foreach ($events as $event_data) {
            $featuresData = prepare_feature_data($featuresData, $event_data);
        }
    }

    /*
     * Per page view all feature value
     */
    $featuresData = per_page_view($featuresData);


    /*
     * Insert/Update per page view data into sale matrix page view table
     */
    insert_update_page_view($cron_name, $featuresData);
}
