<?php

global $scrapper_configs;

$scrapper_configs['whitewatermotors'] = array(
    'entry_points' => array(
        'used' => 'https://www.whitewatermotors.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        'use-proxy' => true,
        'srp_page_regex'      => '/\/(?:new|used|certified)-inventory\//i',
        'picture_selectors' => ['.pswp-thumbnail'],
        'picture_nexts' => ['.pswp__button--arrow--right'],
        'picture_prevs' => ['.pswp__button--arrow--left'],
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
                    'model' => str_replace("New","",$obj->model),
                    'body_style' => $obj->bodyStyle,
                    'price' => $obj->internetPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),  
                    'url' => "https://www.whitewatermotors.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );
//  $response_data = HttpGet($car_data['url']);
//            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
//            $matches = [];
//            if (preg_match($regex, $response_data, $matches)) {
//
//                $car_data['description'] = $matches['description'];
//            }
//          $response_data = HttpGet($car_data['url']);
//              $regex = '/.final-price .price-value">(?<price>[^<]+)/';
//            $matches = [];
//            if (preg_match($regex, $response_data, $matches)) {
//
//                $car_data['price'] = $matches['price'];
//            } 
            $to_return[] = $car_data;
        }
            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_whitewatermotors_next_page", "filter_whitewatermotors_next_page", 10, 2);       
 function filter_whitewatermotors_next_page($next, $current_page) {

    
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


add_filter('filter_for_fb_whitewatermotors', 'filter_for_fb_whitewatermotors', 10, 2);

function filter_for_fb_whitewatermotors($car_data, $feed_type)
{
   

    //if($car_data['make']=='GMC'){
         $images = explode('|', $car_data['all_images']);
        unset($images[0]);
    unset($images[1]);
    unset($images[2]);
    unset($images[3]);
    $myimg = array_values($images);
    $car_data['images'] = $myimg;
    $car_data['all_images'] = implode('|', $myimg);
   // }
 
    

    return $car_data;
}
