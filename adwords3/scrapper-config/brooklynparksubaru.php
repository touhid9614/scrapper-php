<?php

global $scrapper_configs;

$scrapper_configs['brooklynparksubaru'] = array(
    'entry_points' => array(
//         'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/MP8825.csv'
//     ),
//     'use-proxy' => false,
//     'vdp_url_regex' => '/\/(?:new|used)\//i',
//     'picture_selectors' => ['.owl-item'],
//     'picture_nexts' => ['.owl-next'],
//     'picture_prevs' => ['.owl-prev'],
//     'refine' => false,
//     'custom_data_capture' => function($url, $resp) {
//         $vehicles = convert_CSV_to_JSON($resp);

//         $result = [];

//         foreach ($vehicles as $vehicle) {
//             if(strpos($vehicle['Vehicle Detail Link'],"www.brooklynparksubaru.com")){
//                  slecho("this vehicles is from www.minnetonkasubaru.com dealership");
//             }
//             else{
//                 continue;
//             }
//             $car_data = [
//                 'stock_number' => $vehicle['Stock #'],
//                 'vin' => $vehicle['VIN'],
//                 'year' => $vehicle['Year'],
//                 'make' => $vehicle['Make'],
//                 'model' => $vehicle['Model'],
//                 'trim' => $vehicle['Series'],
//                 'drivetrain' => $vehicle['Drivetrain Desc'],
//                 'fuel_type' => $vehicle['Fuel'],
//                 'transmission' => $vehicle['Transmission'],
//                 'body_style' => $vehicle['Body'],
//                 'images' => explode('|', $vehicle['Photo Url List']),
//                 'all_images' => $vehicle['Photo Url List'],
//                 'price' => $vehicle['New/Used'] == 'N' ? $vehicle['MSRP'] : $vehicle['Price'] ,
//                 'url' => $vehicle['Vehicle Detail Link'],
//                 // 'url'           => "https://www.brooklynparksubaru.com/auto/*/" . $vehicle['VIN'],
//                 'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
//                 'exterior_color' => $vehicle['Colour'],
//                 'interior_color' => $vehicle['Interior Color'],
//                 'engine' => $vehicle['Engine'],
//                 'description' => strip_tags($vehicle['Description']),
//                 'kilometres' => $vehicle['Odometer'],
//             ];
//              $images = [];
//              $images = explode('|', $car_data['all_images']);
//              if(count($images)<3)
//                  {
//                   //  slecho("total images:" . $car_data['all_images']);
//                      $car_data['all_images']='';
//                  }
     
//             $result[] = $car_data;
//         }

//         return $result;
//     }
// );

        //Missy-> I commented the code seeing the website is changed . if its necessary to use CSV file please do. Also the vehicle detail link (VDP) page link was empty in csv file when i checked//
        'new' => 'https://www.brooklynparksubaru.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
   'certified' => 'https://www.brooklynparksubaru.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_CERTIFIED_USED:inventory-data-bus1/getInventory?start=0&page=1',
   'used' => 'https://www.brooklynparksubaru.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        
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
                    'url' 		 => "https://www.brooklynparksubaru.com{$obj->link}",
                    //'url' => "https://www.brooklynparksubaru.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );
                
                    if(strpos($car_data['url'],"certified")){
                $car_data['stock_type']="certified";
            }

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"src":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_brooklynparksubaru_next_page", "filter_brooklynparksubaru_next_page", 10, 2);       
 function filter_brooklynparksubaru_next_page($next, $current_page) {

    
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
add_filter("filter_brooklynparksubaru_field_images", "filter_brooklynparksubaru_field_images");
    
    function filter_brooklynparksubaru_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }