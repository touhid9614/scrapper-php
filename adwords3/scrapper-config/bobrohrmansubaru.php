<?php

    global $scrapper_configs;

    $scrapper_configs['bobrohrmansubaru'] = array(
       'entry_points' => array(
        'used' => 'https://www.bobrohrmansubaru.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.bobrohrmansubaru.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
       'certified' => 'https://www.bobrohrmansubaru.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_CERTIFIED_USED:inventory-data-bus1/getInventory?start=0&page=1'
 
           ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
       'srp_page_regex'      => '/\/(?:new|used|certified)-inventory\//i',
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
                  //  'stock_type' =>$obj->inventoryType=="New"?strtolower($obj->inventoryType):($obj->inventoryType=="Pre-Owned"?"used":"certified"),
                    'stock_type'   => strtolower($obj->inventoryType),
                    'vin' => $obj->vin,
                    'year' => $obj->modelYear,
                    'make' => $obj->make,
                    'model' => $obj->model,
                    'body_style' => $obj->bodyStyle,
                    'price' => floor($obj->internetPrice),
                    'msrp' => $obj->pricing->msrp,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    'url' => "https://www.bobrohrmansubaru.com{$obj->link}",
                                
                );
                if(strlen($car_data['trim'])>6){
                    $car_data['trim']="";
                }
                $response_data = HttpGet($car_data['url']);
                $regex       =  '/<meta name="description" content="(?<description>[^"]+)/';
                $matches = [];
                if(preg_match($regex, $response_data, $matches)) {

                $car_data['description']=$matches['description'];

                }  


              if(strpos($car_data['url'],"certified")){
                $car_data['stock_type']="cpo";
            }

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_bobrohrmansubaru_next_page", "filter_bobrohrmansubaru_next_page", 10, 2);       
 function filter_bobrohrmansubaru_next_page($next, $current_page) {

    
        $start_tag = 'start=';
        $end_tag = '&';

        if (stripos($current_page, $start_tag)) {
            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
        }

        if (strpos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $rep_value = $resp + 15;


        $find = "start=" . $resp;
        $rep = "start=" . $rep_value;
        $next = str_replace($find, $rep, $current_page);
        slecho($next);
    
    return $next;
}
