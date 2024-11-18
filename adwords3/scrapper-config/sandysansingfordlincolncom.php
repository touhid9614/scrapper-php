<?php
global $scrapper_configs;
$scrapper_configs["sandysansingfordlincolncom"] = array( 
	"entry_points" => array(
	    'new' => 'https://sandysansingfordlincoln.com/sale/cars-daphne-al',
        'used' => 'https://sandysansingfordlincoln.com/sale/used-cars-daphne-al',
    ),
    'vdp_url_regex' => '/\/sale\/[^\/]+\/[0-9]{4}-/i',
    //'ty_url_regex' => '/\/en\/thank-you/i',
    'use-proxy' => true,
    //'refine' => false,
    'picture_selectors' => ['.gallery-delta__thumbnails-item span.overlay img'],
    'picture_nexts' => ['div.gallery-delta-slider__controls a:nth-of-type(2)'],
    'picture_prevs' => ['div.gallery-delta-slider__controls a:nth-of-type(1)'],
    
    'details_start_tag' => '<ul id="inv-list" class="grid-view">',
    'details_end_tag' => '<footer id="main-footer"',
    'details_spliter' => '<li class="ui raised segment',
    'data_capture_regx' => array(
        'url' => '/veh-title-bar group">\s*<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'title' => '/veh-title-bar group">\s*<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'stock_number' => '/STOCK:<\/span>\s*(?<stock_number>[^<]+)/',
        'vin' => '/VIN:<\/span>\s*(?<vin>[^<]+)/',
        'year' => '/veh-title-bar group">\s*<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/veh-title-bar group">\s*<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/veh-title-bar group">\s*<h2><a href="(?<url>[^"]+)">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'transmission' => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'price' => '/Your Price:[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',    
        'exterior_color' => '/Exterior:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        
    ),
    'next_page_regx' => '/<a class="item" data-page="[^"]+"\s*href="(?<next>[^"]+)">\s*<span[^>]+>Next/',
   // 'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_sandysansingfordlincolncom_field_price", "filter_sandysansingfordlincolncom_field_price", 10, 3);

function filter_sandysansingfordlincolncom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/Price:[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
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
