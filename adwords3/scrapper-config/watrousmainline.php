<?php

global $scrapper_configs;
$scrapper_configs['watrousmainline'] = array(
    'entry_points' => array(
        'new' => 'https://www.watrousmainline.com/new/',
        'used' => 'https://www.watrousmainline.com/used/'
    ),
    'vdp_url_regex' => '/\/vehicle\/[0-9]{4}-/i',
    'srp_page_regex' => '/\/(?:new|used)\//i',
    'refine'    => false,
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<div class="ajax-loading"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style=/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate><var>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'msrp' => '/Watrous GM Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<msrp>[^<]+)/',
        'vin' => '/VIN:[^>]+>[^>]+>(?<vin>[^<]+)/',
        'drivetrain' => '/Drivetrain:[^>]+>[^>]+>(?<drivetrain>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin'           => '/VIN[^>]+>[^>]+>\s*(?<vin>[^\s*]+)/',
        'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^\s*]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'fuel_type' => '/Fuel[^>]+>[^>]+>(?<fuel_type>[^<]+)/',
        'description' => '/<meta name="description" content="(?<description>[^<]+)"/',
        'model'        => '/model:\s*\'\s*(?<model>[^\']+)/',
        'trim'         => '/trim:\s*\'\s*(?<trim>[^\']+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/data-src="(?<img_url>[^"]+)/'
);
add_filter("filter_watrousmainline_field_price", "filter_watrousmainline_field_price", 10, 3);

function filter_watrousmainline_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("watrousmainline Price: $price");
    }

    $msrp_regex = '/MSRP:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }



    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

add_filter("filter_watrousmainline_field_description", "filter_watrousmainline_field_description");

function filter_watrousmainline_field_description($description) {
    return strip_tags($description);
}
add_filter("filter_watrousmainline_field_images", "filter_watrousmainline_field_images");       
function filter_watrousmainline_field_images($im_urls) {
    
   if(count($im_urls)<3)
            {
            return [];
            
            }
       
        return $im_urls;
}
