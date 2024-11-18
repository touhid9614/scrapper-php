<?php

global $scrapper_configs;
$scrapper_configs["tetontoyota"] = array(
    'entry_points' => array(
        'new' => 'https://www.tetontoyota.com/searchnew.aspx',
        'used' => 'https://www.tetontoyota.com/searchused.aspx'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)-[^-]+-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer class="full',
    'details_spliter' => '<div id="srpVehicle',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        //  'title' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'year' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'make' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'model' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/span class="pull-right primaryPrice">(?<price>[^<]+)/',
        'kilometres' => '/Mileage:\s<\/strong>(?<kilometres>[^<]+)/',
        'vin' => '/VIN\s*#:\s*<\/strong><span>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/>Body Style<\/span>\s*<h3 class="[^"]+">(?<body_style>[^<]+)/',
        'transmission' => '/>Transmission \/ Drive Type<\/span>\s*<h3 class="[^"]+">(?<transmission>[^\/]+)/',
        'engine' => '/>Engine<\/span>\s*<h3 class="[^"]+">(?<engine>[^<]+)/',
        'drivetrain' => '/>Transmission \/ Drive Type<\/span>\s*<h3 class="[^"]+">(?<transmission>[^\/]+)\/(?<drivetrain>[^<]+)/',
        'exterior_color' => '/>(?:Ext. Color \/ Int. Color|Ext. Color)<\/span>\s*<h3 class="[^"]+">(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/>(?:Ext. Color \/ Int. Color|Ext. Color)<\/span>\s*<h3 class="[^"]+">(?<exterior_color>[^<\/]+)\/(?<interior_color>[^<]+)/',
        'stock_number' => '/<li>Stock #:(?<stock_number>[^<]+)/',
        'kilometres' => '/<li>Mileage:(?<kilometres>[^<]+)/',
        'vin' => '/<li>VIN:(?<vin>[^<]+)/',
        'price' => '/vdp-price-price[^\$]+\$<\/sup><span\s*>(?<price>[^<]+)/',
    ),
    'next_page_regx' => '/<a\s*href="(?<next>[^"]+)"\s*class="stat-arrow-next"[^>]+>\s*[^"]+"[^"]+"\s*aria-label="Next Page">/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
);
add_filter("filter_tetontoyota_field_price", "filter_tetontoyota_field_price", 10, 3);

function filter_tetontoyota_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:\s<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Internet Price:\s<\/span><span[^>]+>(?<price>\$[0-9,]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/class="priceBlockItemPriceLabel">Retail Price: <\/span><span[^>]+>(?<price>\$[0-9,]+)/';
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

add_filter("filter_tetontoyota_field_images", "filter_tetontoyota_field_images");

function filter_tetontoyota_field_images($im_urls) {

    
    
 if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}



add_filter('filter_tetontoyota_field_url', 'filter_tetontoyota_field_url');
function filter_tetontoyota_field_url($url) {
   $url = str_replace('%2B', '+', $url);
   return $url;
}




