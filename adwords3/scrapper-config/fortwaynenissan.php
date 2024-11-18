<?php

global $scrapper_configs;
$scrapper_configs["fortwaynenissan"] = array(
   
//    //https://app.asana.com/0/687248649257779/1173388334323539
//    'entry_points' => array(
//        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP8761.csv'
//    ),
//    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
//    'ty_url_regex' => '/\/form\/confirm/i',
//    'use-proxy' => true,
//    'refine' => false,
//     'srp_page_regex'      => '/\/(?:new|used|certified)-inventory\//i',
//    'picture_selectors' => ['.slider-slide img'],
//    'picture_nexts' => ['.pswp__button.pswp__button--arrow--right'],
//    'picture_prevs' => ['.pswp__button.pswp__button--arrow--left'],
//    'custom_data_capture' => function($url, $resp) {
//        $vehicles = convert_CSV_to_JSON($resp);
//
//        $result = [];
//
//        foreach ($vehicles as $vehicle) {
//            
//            if(strpos($vehicle['Vehicle Detail Link'],"www.fortwaynenissan.com")){
//                 slecho("this vehicles is from www.fortwaynenissan.com dealership");
//            }
//            else{
//                continue;
//            }
//            
//            $car_data = [
//                'stock_number' => $vehicle['Stock #'],
//                'vin' => $vehicle['VIN'],
//                'year' => $vehicle['Year'],
//                'make' => $vehicle['Make'],
//                'model' => $vehicle['Model'],
//                'trim' => $vehicle['Series'],
//                'drivetrain' => $vehicle['Drivetrain Desc'],
//                'fuel_type' => $vehicle['Fuel'],
//                'transmission' => $vehicle['Transmission'],
//                'body_style' => $vehicle['Body'],
//                'images' => explode('|', $vehicle['Photo Url List']),
//                'all_images' => $vehicle['Photo Url List'],
//                'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
//                'url' => $vehicle['Vehicle Detail Link'],
//                'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
//                'exterior_color' => $vehicle['Colour'],
//                'interior_color' => $vehicle['Interior Color'],
//                'engine' => $vehicle['Engine'],
//                'description' => strip_tags($vehicle['Description']),
//                'kilometres' => $vehicle['Odometer'],
//            ];
//
//
//            $result[] = $car_data;
//        }
//
//        return $result;
//    }
//);
"entry_points" => array(
	  'used' => 'https://www.fortwaynenissan.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.fortwaynenissan.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
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
                  //   'price' => $conditional > 0 ? ($finalPrice > $conditional ? $conditional:($finalPrice==0? "please call": $finalPrice)):($finalPrice==0 ? "please call": $finalPrice), 
                    'trim' => $obj->trim,
                    'msrp' => $obj->msrp,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    'url' => "https://www.fortwaynenissan.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );

            $response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }
             $response_data = HttpGet($car_data['url']);
            $regex = '/final-price .price-value">(?<price>[^<]+)/';
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
        
 add_filter("filter_fortwaynenissan_next_page", "filter_fortwaynenissan_next_page", 10, 2);       
 function filter_fortwaynenissan_next_page($next, $current_page) {

    
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
