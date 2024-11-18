<?php
global $scrapper_configs;
$scrapper_configs["lagunaniguelhyundaicom"] = array( 
    'entry_points' => array(
        'new' => 'https://www.lagunaniguelhyundai.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
        'used' => 'https://www.lagunaniguelhyundai.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
        //'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,
        'srp_page_regex'       => '/\/(?:new|used)-inventory\//i',
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
        
              $finalPrice=(int)str_replace([",","\$"], ["",""],trim(($obj->pricing->finalPrice)));
              $conditional=(int)str_replace([",","\$"], ["",""],trim(($obj->pricing->SICFRule)));
              
                $car_data = array(
                    'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                    'stock_type' => $obj->newOrUsed,
                    'vin' => $obj->vin,
                    'year' => $obj->modelYear,
                    'make' => $obj->make,
                    'model' => $obj->model,
                    'body_style' => $obj->bodyStyle,
                    //'price' => $conditional > 0 ? ($finalPrice > $conditional ? $conditional:($finalPrice==0? "please call": $finalPrice)):($finalPrice==0 ? "please call": $finalPrice),              
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    //'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    //'url' => "https://www.lagunaniguelhyundai.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                    'url' 		 => "https://www.lagunaniguelhyundai.com{$obj->link}",            
                );
                $response_data = HttpGet($car_data['url']);
                $regex = '/.final-price .price-value">(?<price>[^<]+)/';
                $custom_regex= '/aria-label="Details">Financing Offer\s*\:(?<custom>[^<]+)/';
                $matches = [];
                if (preg_match($regex, $response_data, $matches)) {
                    $car_data['price'] = $matches['price'];
                }  
                if (preg_match($custom_regex, $response_data, $matches)) {
                    $car_data['custom'] = $matches['custom'];
                }  
                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
);
        
 add_filter("filter_lagunaniguelhyundaicom_next_page", "filter_lagunaniguelhyundaicom_next_page", 10, 2);       
 function filter_lagunaniguelhyundaicom_next_page($next, $current_page) {
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

// add_filter('filter_for_fb_lagunaniguelhyundaicom', 'filter_for_fb_lagunaniguelhyundaicom', 10, 2);

// function filter_for_fb_lagunaniguelhyundaicom($car_data, $feed_type)
// {
//     // apply condition for other feeds inside this condition
//     if(in_array($feed_type, ['aia', 'retergating', 'carousel', 'fb-catalogue', 'fb_catalogue'])) {
//         if(strpos($car_data['all_images'], 'unavailable_stockphoto.png') !== false ){
//             $car_data['all_images'] = "";
//         }

//         return $car_data;
//     }

//     return $car_data;
// }
    
add_filter('filter_lagunaniguelhyundaicom_car_data', 'filter_lagunaniguelhyundaicom_car_data');

function filter_lagunaniguelhyundaicom_car_data($car_data)
{               
    
    if(strpos($car_data['all_images'], 'unavailable_stockphoto.png') !== false ){
        $car_data['all_images'] = "";
    }
    
    return $car_data;
}
