<?php
$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once 'statistics_functions.php';
global $scrapper_configs;

$get_dealer     = filter_input(INPUT_GET, 'dealership');    

//$eventData = [];
$selectedFeatures = [
    'page_view' => 'PageView',
    'time30s' => 'Time > 30 Secons',
    'time60s' => 'Time > 60 Seconds',
    'time90s' => 'Time > 90 Seconds',
    'scroll25' => 'Scroll > 25',
    'scroll50' => 'Scroll > 50',
    'scroll75' => 'Scroll > 75',
    'scroll100' => 'Scroll 100',
    'button_click' => 'Button Click',
    'image_hovered' => 'Image Hovered',
    'image_clicked' => 'Image Clicked'
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
        $vdp_url_regex = $scrapper_configs[$cron_name]['vdp_url_regex'];
        
     /*
         * Get all files from all subdirectory of dealer domain directory
         */
        $data_files = [];
        $file_dir_name = $adwords_dir . "data/session/$domain_name";
        if(!is_dir($file_dir_name))            continue;

        /*
         * reandomly go upto 30 date back from today and exit when get 15 files
         * because sometimes we don't get file for every day
         * NOTE: Don't look past 30 days
         */
        
           for ($i = 1; $i  <= 100; $i++) {
                $data_date = strtotime('-' . $i . 'days', time());
                $year = date('Y', $data_date);
                $month = date('F', $data_date);
                $day = date('d', $data_date);           
                $file_name = $file_dir_name . "/$year/$month/$day.json";
                    if (file_exists($file_name)) {
                           $data_files[] = $file_name;
                    }
                    if(count($data_files) == 15) {
                        break;
                    }
           }

        $daysFeatureData = [];  
        foreach ($data_files as $file_key => $file_name) {
            $featuresData = [];
            $distinctVdpURLCount = [];
            $file_content = unserialize(file_get_contents($file_name));
            foreach ($file_content as $session_id => $session_data) {
                foreach ($session_data['_views'] as $view_id => $view_data) {
                    $url = $view_data['url'];
                    /*
                     * Check url with vdp url regex to identify vdp url
                     */
                    if(!preg_match($vdp_url_regex, $url)) {
                        continue;
                    }
                    
                    $distinctVdpURLCount[$url] = $url; 
                    
                    /*
                     * Calculate events data value
                     */
                        foreach ($view_data['_events'] as $eventId => $event_data) {
                            $featuresData['page_view']  += 1;
                            if ($event_data['action'] == 'TimeOnPage') {
                                $timeonpage = $event_data['value'] / 1000;
                                $featuresData['time30s'] += ($timeonpage >= 10) ? 1 : 0;
                                $featuresData['time60s'] += ($timeonpage >= 20) ? 1 : 0;
                                $featuresData['time90s'] += ($timeonpage >= 30) ? 1 : 0;
                            } else if ($event_data['action'] == 'ScrollDepth') {
                                $scrollpercentage = $event_data['value'];
                                $featuresData['scroll25'] += ($scrollpercentage >= 25) ? 1 : 0;
                                $featuresData['scroll50'] += ($scrollpercentage >= 50) ? 1 : 0;
                                $featuresData['scroll75'] += ($scrollpercentage >= 75) ? 1 : 0;
                                $featuresData['scroll100'] += ($scrollpercentage == 100) ? 1 : 0;
                            } else if ($event_data['action'] == 'ButtonClick') {
                                $featuresData['button_click'] += 1;
                            } else if ($event_data['action'] == 'Hover') {
                                $tag = isset($event_data['date']['Tag']) ? $event_data['date']['Tag'] : '';
                                $width = isset($event_data['date']['Area']['width']) ? $event_data['date']['Area']['width'] : 0;
                                $height = isset($event_data['date']['Area']['height']) ? $event_data['date']['Area']['height'] : 0;
                                $featuresData['image_hovered'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
                            } else if ($event_data['action'] == 'Click') {
                                $tag = isset($event_data['date']['Tag']) ? $event_data['date']['Tag'] : '';
                                $width = isset($event_data['date']['Area']['width']) ? $event_data['date']['Area']['width'] : 0;
                                $height = isset($event_data['date']['Area']['height']) ? $event_data['date']['Area']['height'] : 0;
                                $featuresData['image_clicked'] += ($tag == 'IMG' && $width > 320 && $height > 240) ? 1 : 0;
                            }
                        }
                }
            }
            echo '<pre>';
              
            $url_count = count($distinctVdpURLCount);
            /*
             * Caculate per day mean of all events with respect to number of distinct url
             */
            if($url_count) {
                foreach ($selectedFeatures as $key => $value) {
                    $daysFeatureData[$file_key][$key] = isset($featuresData[$key]) ? ($featuresData[$key]/$url_count) : 0; 
               }
            } else {
                foreach ($selectedFeatures as $key => $value) {
                    $daysFeatureData[$file_key][$key] = 0; 
                }
            }           
        }
        print_r($daysFeatureData);
        
        
        

        /*
           * Prepare  data to calculate mean and sd
           */
          $carData = [];
          foreach ($daysFeatureData as $url => $data) {
              foreach ($selectedFeatures as $key => $value) {
                  $carData[$key][] = $daysFeatureData[$url][$key];
              }
          }
        print_r($carData);


        /*
         * Finally calculation of mean and sd in total
         */
            $finalFeaturesData = [];
            if (count($carData)) {
                $standard_deviation = 0;
                foreach ($selectedFeatures as $key => $value) {
                    $finalFeaturesData[$key]['mean'] = calc_mean($carData[$key], $standard_deviation);
                    $finalFeaturesData[$key]['sd'] = $standard_deviation;
                }
            }

        print_r($finalFeaturesData);


            /*
             * Insert/Update mean and sd data into salematrix_overall table
             */
            if (count($finalFeaturesData)) {
                $mean = [];
                $sd = [];
                foreach ($finalFeaturesData as $key => $value) {
                    $mean[$key] = $value['mean'];
                    $sd[$key] = $value['sd'];
                }

                $salematrixQuery = DbConnect::get_instance()->query("SELECT * FROM salematrix_days WHERE dealership='{$cron_name}'");
                $current_time = date('Y-m-d H:i:s');
                if ($salematrixQuery->num_rows) {
                    $updateStrMean = "UPDATE salematrix_days SET ";
                    foreach ($mean as $key => $value) {
                        $updateStrMean .= "$key = $value, ";
                    }
                    $updateStrMean .= "last_updated = '$current_time', ";
                    $updateStrMean = rtrim($updateStrMean, ', ');
                    $updateStrMean .= " WHERE dealership = '$cron_name' AND calc_type = 'mean'";

                    $updateStrSD = "UPDATE salematrix_days SET ";
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
                    $sd = implode(',', $sd);
                    DbConnect::get_instance()->query("INSERT INTO salematrix_days VALUES('{$cron_name}', 'mean', {$mean},'{$current_time}')");
                    DbConnect::get_instance()->query("INSERT INTO salematrix_days VALUES('{$cron_name}', 'sd', {$sd},'{$current_time}')");
                }
                echo "Sale Matrix Last 15 days Data Updated For " . $cron_name . " <br>";   
            }
    }

    
    
    


   