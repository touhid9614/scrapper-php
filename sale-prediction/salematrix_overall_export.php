<?php

$base_dir = dirname(__DIR__);
$adwords_dir = "$base_dir/adwords3/";

require_once $adwords_dir . 'config.php';
require_once $adwords_dir . 'db_connect.php';
require_once $adwords_dir . 'tag_db_connect.php';
require_once $adwords_dir . 'utils.php';
require_once 'statistics_functions.php';

$get_dealer     = filter_input(INPUT_GET, 'dealership');

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$get_dealer.csv");
header("Pragma: no-cache");
header("Expires: 0");


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
        $allactive_dealers = [];
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
        
        $wrote_header = false;
        
        foreach($featuresData as $feature) {
            if(!$wrote_header) {
                write_csv(array_keys($feature));
                $wrote_header = true;
            }
            write_csv(array_values($feature));
        }
  }
  
function write_csv($data) {
    $str = implode("\",\"", $data);
    echo "\"$str\"\n";
}

 $db_connect->close_connection(DbConnect::CLOSE_READ_CONNECTION);
  