<?php

global $scrapper_configs;

$scrapper_configs['tacomaminicom'] = array(
     'entry_points' => array(
        'new' => 'https://www.tacomamini.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1&accountId=tacomaminicom',
        'used' => 'https://www.tacomamini.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1&accountId=tacomaminicom',
        
        
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
       // 'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,
        'custom_data_capture' => function($url, $data) {

            $objects = json_decode($data);

            if (!$objects) {
                slecho($data);
            }

            $to_return = array();

            foreach ($objects->pageInfo->trackingData as $obj) {

                $car_data = array(
                    'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                    'stock_type' => $obj->newOrUsed,
                    'vin' => $obj->vin,
                    'year' => $obj->modelYear,
                    'make' => $obj->make,
                    'model' => $obj->model,
                    'body_style' => $obj->bodyStyle,
                    'price' => $obj->pricing->finalPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    'all_images'            => $obj->images[0]->uri,        
                    'url' => "https://www.tacomamini.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );
                
                // $response_data = HttpGet($car_data['url']);
                // $images_regex = '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/';
                // $matches = [];
                // if(preg_match_all($images_regex, $response_data, $matches))
                // {
                //     // slecho($response_data);
                //     $car_data['images']     = $matches['img_url'];
                //     $car_data['all_images'] = implode('|', $car_data['images']);
                // }

                // if($car_data['all_images'] == ""){
                //     $response_data = HttpGet($car_data['url']);
                //     $images_regex = '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/';
                //     $matches = [];
                //     if(preg_match_all($images_regex, $response_data, $matches))
                //     {
                //         $car_data['images']     = $matches['img_url'];
                //         $car_data['all_images'] = implode('|', $car_data['images']);
                //     }
                // }

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
);
        
 add_filter("filter_tacomaminicom_next_page", "filter_tacomaminicom_next_page", 10, 2);       
 function filter_tacomaminicom_next_page($next, $current_page) {

    
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


add_filter('filter_tacomaminicom_car_data', 'filter_tacomaminicom_car_data');

function filter_tacomaminicom_car_data($car_data) {

    if ($car_data['stock_number'] === 'M11088') {
        slecho("Excluding car that has stock number 17N052 ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}
