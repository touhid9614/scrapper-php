<?php

global $scrapper_configs;

$scrapper_configs['whitebearlincoln'] = array(
    'entry_points'        => array(

        'new'  => 'https://www.whitebearlincoln.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
        
        'used' => 'https://www.whitebearlincoln.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        
    ),
    'vdp_url_regex'       => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'srp_page_regex'      => '/\/(?:new|used|certified)-inventory\//i',
    'use-proxy'           => true,
    'picture_selectors'   => ['.pswp-thumbnail'],
    'picture_nexts'       => ['.pswp__button--arrow--right'],
    'picture_prevs'       => ['.pswp__button--arrow--left'],
    'custom_data_capture' => function ($url, $data) {
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
                   // 'price' => $obj->internetPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    'url' => "https://www.whitebearlincoln.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );
                
            $response_data = HttpGet($car_data['url']);
            $regex = '/<meta name="description" content="(?<description>[^"]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['description'] = $matches['description'];
            }
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
    'next_page_regx'      => '/enableMyCars":(?<next>[^"]+)/',
    'images_regx'         => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
);

add_filter("filter_whitebearlincoln_next_page", "filter_whitebearlincoln_next_page", 10, 2);
function filter_whitebearlincoln_next_page($next, $current_page)
{

    $start_tag = 'start=';
    $end_tag   = '&';

    if (stripos($current_page, $start_tag)) {
        $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
    }

    if (strpos($resp, $end_tag)) {
        $resp = substr($resp, 0, stripos($resp, $end_tag));
    }

    $rep_value = $resp + 18;

    $find = "start=" . $resp;
    $rep  = "start=" . $rep_value;
    $next = str_replace($find, $rep, $current_page);
    slecho($next);

    return $next;
}

add_filter("filter_whitebearlincoln_field_price", "filter_whitebearlincoln_field_price", 10, 3);
add_filter('filter_whitebearlincoln_car_data', 'filter_whitebearlincoln_car_data');


function filter_whitebearlincoln_car_data($car_data) {
    //taking all cars except Corvette

   if(strpos($car_data['model'], "RX") || strpos($car_data['model'], "Interceptor")) {
    return null;
   }


    return $car_data;
}


function filter_whitebearlincoln_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
