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

        /*
         * Get all files from all subdirectory of dealer domain directory
         */
        $data_files = [];
        $file_dir_name = $adwords_dir . "data/session/$domain_name";
        if(!is_dir($file_dir_name))            continue;            
        
        /*
         * Get all files from dealer domain directory
         * NOTE: This shall be also based on last 15 days, Don't look past 30 days
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
        * initialize every feature with zero value
        */
           foreach ($selectedFeatures as $key => $value) {
               $featuresData[$key] = 0;
           }

        foreach ($data_files as $file_name) {
            $file_content = unserialize(file_get_contents($file_name));
            foreach ($file_content as $session_id => $session_data) {
                foreach ($session_data['_views'] as $view_id => $view_data) {                  
                    
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
        }

        /*
         * Per page view all feature value
         */
        if($featuresData['page_view']) {
            $page_view = $featuresData['page_view'];
            foreach ($selectedFeatures as $key => $value) {
                $featuresData[$key] = ($featuresData[$key] / $page_view);
            }
        }



        /*
         * Insert/Update per page view data into salematrix_pageview table
         */
            $salematrixQuery = DbConnect::get_instance()->query("SELECT * FROM salematrix_pageview WHERE dealership='{$cron_name}'");
            $current_time = date('Y-m-d H:i:s');
            if($salematrixQuery->num_rows) {
                $updateStr = "UPDATE salematrix_pageview SET ";
                foreach ($featuresData as $key => $value) {
                    $updateStr .= "$key = $value, ";
                }
                $updateStr .= "last_updated = '$current_time', ";
                $updateStr = rtrim($updateStr, ', ');
                $updateStr .= " WHERE dealership = '$cron_name'"; 
                DbConnect::get_instance()->query($updateStr);
            } else {
               $databyComma = implode(',', $featuresData);
                DbConnect::get_instance()->query("INSERT INTO salematrix_pageview VALUES('{$cron_name}', {$databyComma},'{$current_time}')");              
            }
        echo "Sale Matrix Page View Data Updated For " . $cron_name . " <br>";    
  }
 $db_connect->close_connection();