<?php
global $scrapper_configs;
$scrapper_configs["millsautocom"] = array( 
	"entry_points" => array(
    	 'used' => 'https://www.millsauto.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.millsauto.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
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
                    //'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                   // 'url' => "https://www.lairdwheatoncadillac.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                    'url' 		 => "https://www.millsauto.com{$obj->link}",
                                
                );
                    
            if (($car_data['vin'] === '1N6AD0EV7KN750401') || ($car_data['vin'] === '1FTFW1ET5CFA49293') || ($car_data['vin'] === '3GTU2PEJXHG455452') || ($car_data['vin'] === '1FAHP2MK9EG153566')) {
                slecho("Excluding car that has  ,{$car_data['url']}");
                continue;
            }

            $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_millsautocom_next_page", "filter_millsautocom_next_page", 10, 2);       
 function filter_millsautocom_next_page($next, $current_page) {

    
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

//add_filter('filter_millsautocom_car_data', 'filter_millsautocom_car_data');
//
//function filter_millsautocom_car_data($car_data) {
//
//     //$car_data['model'] =  strtolower(  $car_data['model'] );
//     
//     if (($car_data['vin'] === '1N6AD0EV7KN750401')||($car_data['vin'] === '1FTFW1ET5CFA49293')||($car_data['vin'] === '3GTU2PEJXHG455452')||($car_data['vin'] === '1FAHP2MK9EG153566')) {
//        slecho("Excluding car that has  ,{$car_data['url']}");
//        return null;
//    }
//    return $car_data;
//}
add_filter("filter_millsautocom_field_images", "filter_millsautocom_field_images");

    
    function filter_millsautocom_field_images($im_urls)
    {
        unset($im_urls[0]);
       if(count($im_urls)<4)
            {
            return [];
            
            }
       
        return $im_urls;
    }