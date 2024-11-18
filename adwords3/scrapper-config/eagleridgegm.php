<?php

global $scrapper_configs;

$scrapper_configs['eagleridgegm'] = array(
     'entry_points' => array(
             'used'  => 'https://www.eagleridgegm.com/used/',
             'new'   => 'https://www.eagleridgegm.com/new/',
             
        ),
        'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
        'use-proxy'              => true,
        'refine'                 => false,
        'picture_selectors'      => ['.thumb li'],
        'picture_nexts'          => ['.next'],
        'picture_prevs'          => ['.prev'],
        'details_start_tag'      => '<div class="instock-inventory-content',
        'details_end_tag'        => '<footer class="',
        'details_spliter'        => '<div itemprop="ItemOffered"',
        'data_capture_regx'      => array(
            'url'               => '/<a itemprop="url"\s*onclick="[^"]+" href="(?<url>[^"]+)"/',
            'price'             => '/Internet Price:[^>]+>[^>]+>[^>]+>[^>]+>\s*[^>]+>[^>]+>[^>]+>(?<price>[^\<]+)/',
            'stock_number'      => '/STK#\s*(?<stock_number>[^\/]+)/',
              'make'            => '/itemprop=\'manufacturer\' notranslate><var>(?<make>[^\s*]+)/',
             'model'            => '/itemprop=\'model\' notranslate><var>(?<model>[^<]+)/',
                'year'          => '/itemprop=\'releaseDate\'.*>(?<year>[0-9]{4})/',
          
        ),
        'data_capture_regx_full' => array(

            'engine'         => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
            'transmission'   => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
            'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
            'kilometres'     => '/class="mileage-used-value">\s*[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'body_style'     => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
            'vin'            => '/\&vin=(?<vin>[^\&]+)/',
           
        ),
        'next_page_regx'         => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'            => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)/'
    );
    
    add_filter('filter_eagleridgegm_car_data', 'filter_eagleridgegm_car_data');

function filter_eagleridgegm_car_data($car_data) {
   
        if(strlen($car_data['model'])>20){
        return null;
    }

    return $car_data;
}
    add_filter("filter_eagleridgegm_field_price", "filter_eagleridgegm_field_price", 10, 3);

   function filter_eagleridgegm_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Suggested Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<])/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
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
add_filter("filter_for_aia_eagleridgegm", "filter_for_aia_eagleridgegm", 10, 1);

function filter_for_aia_eagleridgegm($car)
{
    if ($car['price'] == "$0.00") {
        $car = [];
    }

    return $car;
}