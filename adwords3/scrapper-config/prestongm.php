<?php

global $scrapper_configs;

$scrapper_configs['prestongm'] = array(
    'entry_points' => array(
         'used' => 'https://www.prestongm.com/used/',
        'new' => 'https://www.prestongm.com/new/',
       
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next'],
    'picture_prevs'          => ['.prev'],
    'details_start_tag'      => '<div class="instock-inventory-content',
    'details_end_tag'        => '<footer class="',
    'details_spliter'        => '<!-- vehicle-list-cell -->',
    'data_capture_regx'      => array(
        'url'            => '/href="(?<url>[^"]+)"><span\s*style=\'/',
        'price'          => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres'     => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'engine'         => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'drivetrain'     => '/"driveTrain":"(?<drivetrain>[^"]+)/'
    ),
    'data_capture_regx_full' => array(
        'make'           => '/make:\s*\'(?<make>[^\']+)/',
        'model'          => '/model:\s*\'(?<model>[^\']+)/',
        'year'           => '/year:\s*\'(?<year>[^\']+)/',
        //'kilometres'     => '/mileage-list"  >Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)<\/span><\/p>/',
        'stock_number'   => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'body_style'     => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'vin'            => '/\&vin=(?<vin>[^\&]+)/',
        'fuel_type'      => '/itemprop="fuelType">(?<fuel_type>[^<]+)/',
        'description'    => '/name="description" content="(?<description>[^"]+)/',
        'custom'         => '/Location Alert:\s*<\/strong>(?<custom>[^o]+)/',
    ),
    'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx'            => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)/'
);


add_filter("filter_prestongm_field_price", "filter_prestongm_field_price", 10, 3);
function filter_prestongm_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("prestongm Price: $price");
    }

    $suggested_regex = '/Suggested Price:[^>]+>[^>]+>[^>]+>(?<price>\$[0-9,]+)/';


    $matches = [];



    if (preg_match($suggested_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex suggested: {$matches['price']}");
    }


    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
add_filter("filter_prestongm_field_images", "filter_prestongm_field_images");

function filter_prestongm_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'new_vehicles_images_coming.png');
    });
}

 add_filter("filter_prestongm_field_model", "filter_prestongm_field_model");
 function filter_prestongm_field_model($model)
 {
      if(strpos($model,"olt")){
        return null;
     }
     return $model;
 }