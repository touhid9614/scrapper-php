<?php

require_once dirname(dirname(__DIR__)) . "/sale-prediction/process-redshift/config.php";

function insert_update_daily($cron_name, $featuresData)
{
    if (count($featuresData)) {
        $dealerExist = dealer_exist_in_table('salematrix_days', $cron_name);
        $current_time = date('Y-m-d H:i:s');

        if ($dealerExist->fetch()) {
            $where['dealership'] = $cron_name;
            $where['calc_type'] = 'mean';

            $featuresData['mean']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_days', $featuresData['mean'], $where);

            $where['calc_type'] = 'sd';
            $featuresData['sd']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_days', $featuresData['sd'], $where);

            echo "Sale Matrix Last 15 days Data Updated For " . $cron_name . " <br>";
        } else {
            $featuresData['mean']['dealership'] = $cron_name;
            $featuresData['mean']['calc_type'] = 'mean';
            $featuresData['mean']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_days', $featuresData['mean']);

            $featuresData['sd']['dealership'] = $cron_name;
            $featuresData['sd']['calc_type'] = 'sd';
            $featuresData['sd']['last_updated'] = $current_time;
            ConnectMysql::get_instance()->exeInsertOrUpdate('salematrix_days', $featuresData['sd']);

            echo "Sale Matrix Last 15 days Data Insert For " . $cron_name . " <br>";
        }
    }
}

/*
 * Get All dealer and website Url
 */
$get_dealer = filter_input(INPUT_GET, 'dealership');

if ($get_dealer) {
    $allactive_dealers = get_all_dealer($get_dealer);
} else {
    $allactive_dealers = get_all_dealer();
}

foreach ($allactive_dealers as $cron_name => $website) {

    /*
     * Get the Vdp url Regex from scrapper config file
     */
    $config_file = get_file_by_pattern($cron_name);
    if ($config_file) {
        require_once $config_file;
        $scrapper_config = $scrapper_configs[$cron_name];
        $vdp_url_regex = $scrapper_config['vdp_url_regex'];
    } else {
        continue;
    }

    $daysFeatureData = [];
    $selectedFeatures = feature_list();

    /*
     * rand only go upto 30 date back from today and exit when get 15 files
     * because sometimes we don't get file for every day
     * NOTE: Don't look past 30 days
     */
    $today = time();
    $count = 0;
    for ($i = 1; $i <= 30; $i++) {

        $previous_date = strtotime('- 1 days', $today);
        $pageViews = get_all_page_view($website, ' < ' . $today . ' AND last_updated >' . $previous_date);

        if ($count > 14) {
            break;
        }

        /*
         *  Get Features Data Array
         */
        $featuresData = feature_data();

        $distinctVdpURLCount = [];

        if (count($pageViews)) {
            foreach ($pageViews as $pageView) {
                $url = $pageView['url'];
                /*
                 * Check url with vdp url regex to identify vdp url
                 */
                if (!preg_match($vdp_url_regex, $url)) {
                    continue;
                }

                $distinctVdpURLCount[$url] = $url;
                $events = get_all_event($pageView['view_id']);
                foreach ($events as $event_data) {
                    $featuresData = prepare_feature_data($featuresData, $event_data);
                }
            }
            $count++;
        }

        $today = $previous_date;
        $url_count = count($distinctVdpURLCount);
        /*
         * Caculate per day mean of all events with respect to number of distinct url
         */
        if ($url_count) {
            foreach ($selectedFeatures as $key => $value) {
                $daysFeatureData[$count][$key] = isset($featuresData[$key]) ? ($featuresData[$key] / $url_count) : 0;
            }
        } else {
            $daysFeatureData[$count] = feature_data();
        }
    }

    /*
     * Prepare car data to calculate mean and sd
     */
    $featuresData = pre_possess_feature_data($daysFeatureData);

    /*
     * Finally calculation of mean and sd in total
     */
    $featuresData = cal_mean_sd($featuresData);


    /*
     * Insert/Update mean and sd data into sale matrix daily table
     */
    insert_update_daily($cron_name, $featuresData);


}

