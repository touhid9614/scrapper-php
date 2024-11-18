<?php
global $scrapper_configs;
$scrapper_configs["citymitsubishicom"] = array( 
	'entry_points' => array(
        'new'  => 'https://www.citymitsubishi.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
        'used' => 'https://www.citymitsubishi.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        
         
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified|exotic-used)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.prev'],
    
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
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    'url' 			 => "https://www.citymitsubishi.com{$obj->link}",
                    //'url' => "https://www.citymitsubishicom.ca/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );
                    
                    $response_data = HttpGet($car_data['url']);
                    $regex       =  '/ddc-font-size-large d-inline-block">\s*(?<finance>\$[0-9]+)\s*<\/strong>/';
                    $matches = [];
                     if(preg_match($regex, $response_data, $matches)) {

                     $car_data['finance']=$matches['finance'];

                    }      
                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
        
    
);

        
 add_filter("filter_citymitsubishicom_next_page", "filter_citymitsubishicom_next_page", 10, 2);       
 function filter_citymitsubishicom_next_page($next, $current_page) {

    
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
        