<?php

global $scrapper_configs;
$scrapper_configs["schaumburghondaautos"] = array(
    'entry_points' => array(
        'new' => 'https://www.schaumburghondaautos.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
        'used' => 'https://www.schaumburghondaautos.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified|wholesale-new|wholesale-used|exotic-new|exotic-used)\/[^\/]+\/[0-9]{4}-/i',
       'srp_page_regex'      => '/(?:used|new|certified)-inventory\/index/i',
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
                    'msrp' => explode('.', $obj->msrp)[0],
                    'model' => $obj->model,
                    'body_style' => $obj->bodyStyle,
                    // 'price' => $obj->pricing->finalPrice,
                    'price' => explode('.',$obj->askingPrice)[0],
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    // 'url' => "https://www.schaumburghondaautos.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                    'url' 		 => "https://www.schaumburghondaautos.com{$obj->link}",            
                );

             $response_data = HttpGet($car_data['url']);
            $regex       =  '/<meta name="og:description" content="(?<description>[^"]+)/';
            $matches = [];
             if(preg_match($regex, $response_data, $matches)) {
           
             $car_data['description']=$matches['description'];
             
            }      
            $to_return[] = $car_data;
        }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_schaumburghondaautos_next_page", "filter_schaumburghondaautos_next_page", 10, 2);       
 function filter_schaumburghondaautos_next_page($next, $current_page) {

    
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
add_filter("filter_schaumburghondaautos_field_images", "filter_schaumburghondaautos_field_images");

function filter_schaumburghondaautos_field_images($im_urls)
    {
        $retval = [];
        
        foreach($im_urls as $img)
        {
            $retval[] = $img . "?impolicy=resize&w=768";
        }
        
        return $retval;
    }
    
    add_filter('filter_for_fb_schaumburghondaautos', 'filter_for_fb_schaumburghondaautos', 10, 2);

function filter_for_fb_schaumburghondaautos($car_data, $feed_type)
{
    if(strpos($car_data['all_images'], 'unavailable_stockphoto') ){
        //$car_data['all_images'] = "";
        return null;
    }
    return $car_data;
}


