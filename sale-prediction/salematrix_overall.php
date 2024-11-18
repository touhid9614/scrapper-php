<?php
$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once 'statistics_functions.php';

$get_dealer     = filter_input(INPUT_GET, 'dealership');    


//$eventData = [];
$selectedFeatures = [
    'page_view'     => 'PageView', 
    'time30s'       => 'Time > 30 Secons',
    'time60s'       => 'Time > 60 Seconds', 
    'time90s'       => 'Time > 90 Seconds',
    'scroll25'      => 'Scroll > 25',
    'scroll50'      => 'Scroll > 50',
    'scroll75'      => 'Scroll > 75',
    'scroll100'     => 'Scroll 100',
    'button_click'  => 'Button Click',
    'image_hovered' => 'Image Hovered',
    'image_clicked' => 'Image Clicked',
    'day_to_sale' => 'Day to Sale'
];


    $db_connect = new DbConnect('');
    if ($get_dealer) 
    {
        $allactive_dealers = $db_connect->get_all_dealers("`dealership` = '$get_dealer'");
    }  
    else 
    {
        $allactive_dealers = $db_connect->get_all_dealers("`status` = 'active' OR `status` = 'trial' OR `status` = 'trial-setup'");
    }
    
    foreach ($allactive_dealers as $cron_name => $dealer_data) 
    {
        $domain_name = getDealerDomain($cron_name);
        $featuresData = [];          

        /*
         * Get all files from all subdirectory of dealer domain directory
         */
        $data_files = [];
        $file_dir_name = $adwords_dir . "data/session/$domain_name";
        if(!is_dir($file_dir_name)) { continue; }
        
        
                /*
         * Get all sold car urls from scraper table
         */
        $soldCarUrls = [];
        $get_allsoldcar = DbConnect::get_instance()->query("SELECT url, arrival_date, updated_at FROM {$cron_name}_scrapped_data WHERE deleted='1'");
        while ($car = mysqli_fetch_assoc($get_allsoldcar)) {
            $soldCarUrls[$car['url']]['days'] = round(($car['updated_at'] - $car['arrival_date'])/(60 * 60 * 24));
        }  
        
        /*
         * Get all files from dealer domain directory
         */
        $iterator = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($file_dir_name), 
                    RecursiveIteratorIterator::SELF_FIRST);
        foreach($iterator as $file) {
            if(is_file($file)) {
                $data_files[] = $file->getRealpath();
           }
        }


        /*
         * Get all car data to a certain date interval
         */

        /*
        for ($i = 60; $i >= 0; $i--) {
            $data_date = strtotime('-' . $i . 'days', time());
            $year = date('Y', $data_date);
            $month = date('F', $data_date);
            $day = date('d', $data_date);

            $file_name = $adwords_dir . "data/session/$domain_name/$year/$month/$day.json";
            if (file_exists($file_name)) {
         *   */


        foreach ($data_files as $file_name) {
            $file_content = unserialize(file_get_contents($file_name));
            foreach ($file_content as $session_id => $session_data) {
                foreach ($session_data['_views'] as $view_id => $view_data) {

                    /*
                     * To match url, check with our scraper table sold car data url
                     */
                    $car_url = "";
                    foreach ($soldCarUrls as $key_url => $car_val) {
                        $url_replace = str_replace(array('http://www.', 'https://www.', 'http', 'https'), '', $key_url);
                        if (strpos($view_data['url'], $url_replace)) {
                            $car_url = $key_url;
                            $view_data['url'] = $key_url;
                            break;
                        }
                    }
                    /*
                     * Skip if not in sold car list
                     */
                    if (!$car_url) { continue; }


                    /*
                     * initialize every url with every events
                     */
                    if (!isset($featuresData[$view_data['url']])) {
                        foreach ($selectedFeatures as $key => $value) {
                            if($key == 'day_to_sale') {
                                $featuresData[$view_data['url']][$key] = $soldCarUrls[$view_data['url']]['days'];
                            } else {
                                $featuresData[$view_data['url']][$key] = 0;
                            }
                            
                        }                        
                    }

                    /*
                     * Calculate events data value
                     */
                    foreach ($view_data['_events'] as $eventId => $event_data) {
                        $featuresData[$view_data['url']]['page_view'] += 1;
                        if ($event_data['action'] == 'TimeOnPage') {
                            $timeonpage = $event_data['value'] / 1000;
                            $featuresData[$view_data['url']]['time30s'] += ($timeonpage >= 10) ? 1 : 0;
                            $featuresData[$view_data['url']]['time60s'] += ($timeonpage >= 20) ? 1 : 0;
                            $featuresData[$view_data['url']]['time90s'] += ($timeonpage >= 30) ? 1 : 0;
                        } else if ($event_data['action'] == 'ScrollDepth') {
                            $scrollpercentage = $event_data['value'];
                            $featuresData[$view_data['url']]['scroll25'] += ($scrollpercentage >= 25) ? 1 : 0;
                            $featuresData[$view_data['url']]['scroll50'] += ($scrollpercentage >= 50) ? 1 : 0;
                            $featuresData[$view_data['url']]['scroll75'] += ($scrollpercentage >= 75) ? 1 : 0;
                            $featuresData[$view_data['url']]['scroll100'] += ($scrollpercentage == 100) ? 1 : 0;
                        } else if ($event_data['action'] == 'ButtonClick') {
                            $featuresData[$view_data['url']]['button_click'] += 1;
                        } else if ($event_data['action'] == 'Hover') {
                            $tag = isset($event_data['date']['Tag']) ? $event_data['date']['Tag'] : '';
                            $width = isset($event_data['date']['Area']['width']) ? $event_data['date']['Area']['width'] : 0;
                            $height = isset($event_data['date']['Area']['height']) ? $event_data['date']['Area']['height'] : 0;
                            $featuresData[$view_data['url']]['image_hovered'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
                        } else if ($event_data['action'] == 'Click') {
                            $tag = isset($event_data['date']['Tag']) ? $event_data['date']['Tag'] : '';
                            $width = isset($event_data['date']['Area']['width']) ? $event_data['date']['Area']['width'] : 0;
                            $height = isset($event_data['date']['Area']['height']) ? $event_data['date']['Area']['height'] : 0;
                            $featuresData[$view_data['url']]['image_clicked'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
                        }
                    }
                }
            }
        }
        


        
        /*
         * We ignore any vehicle that has less than 100 pageviews
         * Not enough data
         */
        
        $featuresData = array_filter($featuresData, function($feature) {
            return $feature['page_view'] > 100;
        });

        /*
         * Prepare car data to calculate mean and sd
         */
        $soldCarData = [];
        foreach ($featuresData as $url => $data) {
            foreach ($selectedFeatures as $key => $value) {
                $soldCarData[$key][] = $featuresData[$url][$key];
            }
        }

        /*
         * Finally calculation of mean and sd in total
         */

        $finalFeaturesData = [];
        if(count($soldCarData)) {
        $standard_deviation = 0;
            foreach ($selectedFeatures as $key => $value) {
                $finalFeaturesData[$key]['mean'] = calc_mean($soldCarData[$key], $standard_deviation);
                $finalFeaturesData[$key]['sd']   = $standard_deviation;
            }
        }



        /*
         * Insert/Update mean and sd data into salematrix_overall table
         */
        if(count($finalFeaturesData)) {
            $mean = [];
            $sd = [];
            foreach ($finalFeaturesData as $key => $value) {        
                $mean[$key] = $value['mean'];
                $sd[$key]   = $value['sd'];
            }

            $salematrixQuery = DbConnect::get_instance()->query("SELECT * FROM salematrix_overall WHERE dealership='{$cron_name}'");
            $current_time = date('Y-m-d H:i:s');
            if($salematrixQuery->num_rows) {
                $updateStrMean = "UPDATE salematrix_overall SET ";
                foreach ($mean as $key => $value) {
                    $updateStrMean .= "$key = $value, ";
                }
                $updateStrMean .= "last_updated = '$current_time', ";
                $updateStrMean = rtrim($updateStrMean, ', ');
                $updateStrMean .= " WHERE dealership = '$cron_name' AND calc_type = 'mean'"; 

                $updateStrSD = "UPDATE salematrix_overall SET ";
                foreach ($sd as $key => $value) {
                    $updateStrSD .= "$key = $value, ";
                }
                $updateStrSD .= "last_updated = '$current_time', ";
                $updateStrSD = rtrim($updateStrSD, ', ');
                $updateStrSD .= " WHERE dealership = '$cron_name' AND calc_type = 'sd'"; 

                DbConnect::get_instance()->query($updateStrMean);
                DbConnect::get_instance()->query($updateStrSD);
            } else {
                $mean = implode(',', $mean);
                $sd   = implode(',', $sd);
                DbConnect::get_instance()->query("INSERT INTO salematrix_overall VALUES('{$cron_name}', 'mean', {$mean},'{$current_time}')");
                DbConnect::get_instance()->query("INSERT INTO salematrix_overall VALUES('{$cron_name}', 'sd', {$sd},'{$current_time}')");
            }
        }
      echo "Sale Matrix Overall Data (Sold Car Only) Updated For " . $cron_name . " <br>";  
  }

 $db_connect->close_connection();
  
//echo '<pre>';
//print_r($mean);
//echo '</pre>';


                            
                            
/*
                            
                            
                            
$soldCarData = [];
$all_event_list = [];
//Remove available car from a list eventData and get only sold car
$get_allsoldcar = DbConnect::get_instance()->query("SELECT url FROM {$cron_name}_scrapped_data WHERE deleted='1'");
while ($car = mysqli_fetch_assoc($get_allsoldcar)) {
    if (isset($eventData[$car['url']])) {
        $event_car = $eventData[$car['url']];
        $soldCarData[$car['url']] = $event_car;
        foreach ($event_car as $event_name => $event_data) {
            $all_event_list[$event_name] = $event_name;
        }        
    }
}

//Calculate mean, sandard deviation, sum for all cars 
$eventCalcData = [];
$standard_deviation = 0;
foreach ($soldCarData as $event_key => $event_value) {
    foreach ($all_event_list as $event_name) { 
        if(isset($soldCarData[$event_key][$event_name])) {
            $eventCalcData[$event_key][$event_name]['mean'] = calc_mean($soldCarData[$event_key][$event_name], $standard_deviation);
            $eventCalcData[$event_key][$event_name]['sd']   = $standard_deviation;
            $eventCalcData[$event_key][$event_name]['sum']  = array_sum($soldCarData[$event_key][$event_name]);
        } else {
            $eventCalcData[$event_key][$event_name]['mean'] = 0;
            $eventCalcData[$event_key][$event_name]['sd']   = 0;
            $eventCalcData[$event_key][$event_name]['sum']  = 0;
        }
    }
}


//Calculate mean, standard deviation for all cars together 
$all_cars_sum = [];
$i = 0;
foreach ($eventCalcData as $event_data) {
    $temp_arr = [];
    foreach ($event_data as $key => $value) {
        $temp_arr[$key] = $value['sum'];
    }
    $all_cars_sum[$i] = $temp_arr;
    $i++;
}


$standard_deviation = array();
$property_mean = property_mean($all_cars_sum, $standard_deviation);
*/

/*
echo '<pre>';
print_r($property_mean);
echo '</pre>';

echo '<pre>';
print_r($standard_deviation);
echo '</pre>'; 
*/
