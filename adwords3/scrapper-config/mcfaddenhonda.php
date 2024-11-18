<?php

global $scrapper_configs;

$scrapper_configs['mcfaddenhonda'] = array(
    'entry_points' => array(
        'certified' => 'https://www.mcfaddenhonda.ca/used/segment/certified/',
        'new' => 'https://www.mcfaddenhonda.ca/new/',
        'used' => 'https://www.mcfaddenhonda.ca/used/',
        
        
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'refine'=>false,
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span/',
        'year' => '/itemprop=\'releaseDate\' notranslate>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\' notranslate>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\' notranslate>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
        'vin' => '/itemprop="sku">(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/itemprop="sku">\s*(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',  
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>\s*(?<kilometres>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
        'vin' => '/itemprop="sku">\s*(?<vin>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
      //  'price' => '/itemprop="price".*\s*[^>]+>(?<price>\$[0-9,]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">.*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*data-src="(?<img_url>[^"]+)/'
);

add_filter("filter_mcfaddenhonda_field_images", "filter_mcfaddenhonda_field_images");
add_filter('filter_mcfaddenhonda_car_data', 'filter_mcfaddenhonda_car_data');

function filter_mcfaddenhonda_car_data($car_data) {
  
    $car_data['make'] = str_replace('&', 'and', $car_data['make']);
    $car_data['model'] = str_replace('&', 'and', $car_data['model']);
    $car_data['exterior_color'] = str_replace('&', 'and', $car_data['exterior_color']);
    return $car_data;
}

function filter_mcfaddenhonda_field_images($im_urls) {
  //  if(count($im_urls) < 2) { return array(); }
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'new_vehicles_images_coming.png');
    });
}
add_filter("filter_mcfaddenhonda_field_price", "filter_mcfaddenhonda_field_price", 10, 3);
function filter_mcfaddenhonda_field_price($price,$car_data, $spltd_data)
    {
        $prices = [];
        
        slecho('');
        
        if($price && numarifyPrice($price) > 0) {
            $prices[] = numarifyPrice($price);
            slecho("Adjusted Price: $price");
        }
        
        $msrp_regex =  '/Sale Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
        
        $matches = [];
        
        if(preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $prices[] = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }
        
        if(count($prices) > 0) {
            $price = butifyPrice(min($prices));
        }
        
        slecho("Sale Price: {$price}".'<br>');
        return $price;
    }

