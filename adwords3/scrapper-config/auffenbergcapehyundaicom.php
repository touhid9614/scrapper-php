<?php
global $scrapper_configs;
$scrapper_configs["auffenbergcapehyundaicom"] = array( 
	"entry_points" => array(
    'new' => 'https://www.auffenbergcapehyundai.com/new-hyundai-cape-girardeau-mo?limit=500',
    'used' => 'https://www.auffenbergcapehyundai.com/used-vehicles-cape-girardeau-mo?limit=500',
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<div class="module-container js-module mod-inventory-listing',
    'details_end_tag' => '<div class="container">',
    'details_spliter' => '<div class="vehicle-item inventory-listing__item',
    'data_capture_regx' => array(
        'stock_number' => '/<span class="vehicle-highlights__subtitle-value">\s*#\s*(?<stock_number>[^\s*]+)/',
        'url' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link vehicle-item__link_no-decoration">/',
        'title' => '/<h6 class="vehicle-item__title[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'year' => '/<h6 class="vehicle-item__title[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'make' => '/<h6 class="vehicle-item__title[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'model' => '/<h6 class="vehicle-item__title[^>]+>\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\n]+))/',
        'price' => '/Final Price\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
       
    ),
    'data_capture_regx_full' => array(
    	 'exterior_color' => '/Exterior Color\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
       // 'engine' => '/Engine:\s*(?<engine>[^<]+)/',
        'transmission' => '/<div class="name_wrapper">Transmission\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'vin' => '/VIN\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'kilometres' => '/Mileage[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/',
    ),
  
    'images_regx' => '/class="main-slider__inner-img" src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_auffenbergcapehyundaicom_field_price", "filter_auffenbergcapehyundaicom_field_price", 10, 3);

function filter_auffenbergcapehyundaicom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/<div class="price_name">\s*Sale Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $internet_regex = '/class="price __final-price">\s*<[^>]+>\s*Internet Price\s*<\/div>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/';
    $cond_final_regex = '/Our Price\s*<\/div>\s*<[^>]+>\s*<[^>]+>\s*<[^>]+>\s*<\/span>\s*<\/a>\s*(?<price>\$[0-9,]+)/';
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
