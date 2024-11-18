<?php

global $scrapper_configs;

$scrapper_configs['bmwnorthwest'] = array(
    'entry_points' => array(
        'used' => 'https://www.bmwnorthwest.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.bmwnorthwest.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
         'srp_page_regex'      => '/\/(?:new|used|certified)-inventory/',
         //'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,

        'custom_data_capture' => function($url, $data) {

            $objects = json_decode($data);

            if (!$objects) {
                slecho($data);
            }

            $to_return = array();
            
            $ignore_data=[
                'B12353A', 
            ];
    

            foreach ($objects->pageInfo->trackingData as $obj) {

                $car_data = array(
                    'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                    'stock_type' => $obj->newOrUsed,
                    'vin' => $obj->vin,
                    'year' => $obj->modelYear,
                    'make' => $obj->make,
                    'model' => str_replace("New","",$obj->model),
                    'body_style' => $obj->bodyStyle,
                    'price' => $obj->internetPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'custom'    => strtok($obj->fuelType, " "),
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    //'url' => "https://www.bmwnorthwest.ca/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                    'url' => "https://www.bmwnorthwest.com{$obj->link}", 
                                
                );
                
                if (in_array($car_data['stock_number'], $ignore_data)) 
                {
                    slecho("Excluding car that has  ,{$car_data['stock_number']}");
                    continue;
                }
                
                
                if($car_data['make']=="MINI")
                {
                    continue;
                }
                
                if($car_data['model']=="760i")
                {
                    continue;
                }

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_bmwnorthwest_next_page", "filter_bmwnorthwest_next_page", 10, 2);       
 function filter_bmwnorthwest_next_page($next, $current_page) {
        $start_tag = 'start=';
        $end_tag = '&';

        if (stripos($current_page, $start_tag)) {
            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
        }

        if (strpos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $rep_value = $resp + 18;


        $find = "start=" . $resp;
        $rep = "start=" . $rep_value;
        $next = str_replace($find, $rep, $current_page);
        slecho($next);
    
    return $next;
}

add_filter('filter_for_fb_bmwnorthwest', 'filter_for_fb_bmwnorthwest', 10, 2);

function filter_for_fb_bmwnorthwest($car, $feed_type) {
    
    if (strpos($car['url'], "certified")) {
        $car['stock_type'] = "cpo";
    }

    return $car;
}
