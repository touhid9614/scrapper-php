<?php
global $scrapper_configs;
 $scrapper_configs["performancelincolnbountiful"] = array( 
	 'entry_points' => array(
        'used' => array(
             'https://www.performancelincolnbountiful.com/used-inventory/non-lincoln.htm',
        ),
             'all' => array(
             'https://www.performancelincolnbountiful.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1',
             'https://www.performancelincolnbountiful.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
            ),     
        
        
        
        
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
    'ty_url_regex' => '/\/form\/confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slider-slide img'],
    'picture_nexts' => ['.pswp__button--arrow--right'],
    'picture_prevs' => ['.pswp__button--arrow--left'],
     
    'used'      => array(
     
    'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
    'details_end_tag' => '<div class="ft">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine( Layout)?:[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior( Colou?r)?:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
        'interior_color' => '/Interior( Colou?r)?:[^>]+>[^>]+>(?<interior_color>[^<\[]+)/',
        'kilometres' => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'certified' => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/',
        'vin'           => '/"vin": "(?<vin>[^"]+)/',
        'drivetrain'    => '/"driveLine": "(?<drivetrain>[^"]+)/',
        'fuel_type'     =>  '/"fuelType": "(?<fuel_type>[^"]+)/',
        
    ),
    'data_capture_regx_full' => array(
        'make' => '/make: \'(?<make>[^\']+)\',/',
        'model' => '/model: \'(?<model>[^\']+)\',/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'price' => '/final-price "[^>]+>\s*<strong class="h1 price"\s*>(?<price>[\$0-9,]+)/',
        'vin'           => '/"vin": "(?<vin>[^"]+)/',
        'drivetrain'    => '/driveLine": "(?<drivetrain>[^"]+)/',
        'fuel_type'     =>  '/fuelType": "(?<fuel_type>[^"]+)/',
    ),
    'next_page_regx' => '/<a class="btn btn-link btn-xs" href="(?<next>[^"]+)"\s*[^"]+"[^"]+"\s*rel="next"/',
    'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)","thumbnail"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
     ),
     
     'all' => array(
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
                    'price' => $obj->internetPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                    'url' 		 => "https://www.performancelincolnbountiful.com{$obj->link}",
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                   // 'url' => "https://www.performancelincolnbountiful.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );

                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   

         
     ),
);
add_filter("filter_performancelincolnbountiful_field_price", "filter_performancelincolnbountiful_field_price", 10, 3);

function filter_performancelincolnbountiful_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue[^=]*="(?<price>[^"]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
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

       
 add_filter("filter_performancelincolnbountiful_next_page", "filter_performancelincolnbountiful_next_page", 10, 2);       
 function filter_performancelincolnbountiful_next_page($next, $current_page) {
        
        if (!strpos($current_page, "non-lincoln")) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        
    
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
        
        }
    return $next;
}
