<?php
global $scrapper_configs;
$scrapper_configs["scharmachautocom"] = array( 
	
	"entry_points" => array(
	  'used' => 'https://www.scharmachauto.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.scharmachauto.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
    ),
    'srp_page_regex'      => '/(?:used|new|certified)-inventory\/index/i',
       'vdp_url_regex' => '/\/(?:new|used|certified|wholesale-new|wholesale-used|exotic-new|exotic-used)\/[^\/]+\/[0-9]{4}-/i',
       // 'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,
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
                   // 'price' => $obj->internetPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'city'              => $obj->accountId,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                   // 'url' => "https://www.ajdohmanncdjr.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                     'url' => "https://www.scharmachauto.com{$obj->link}",
                                
                );
                     
//                 if($car_data['stock_type']=='used' && $car_data['year']=='2022' ){
//                        continue;
//                }
                 $response_data = HttpGet($car_data['url']);
              $regex = '/.final-price .price-value">(?<price>[^<]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['price'] = $matches['price'];
            }  
                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_scharmachautocom_next_page", "filter_scharmachautocom_next_page", 10, 2);       
 function filter_scharmachautocom_next_page($next, $current_page) {

    
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
