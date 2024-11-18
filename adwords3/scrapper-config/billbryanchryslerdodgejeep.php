<?php

global $scrapper_configs;

$scrapper_configs['billbryanchryslerdodgejeep'] = array(
    'entry_points' => array(
        'new' => 'https://www.billbryanchryslerdodgejeep.com/searchnew.aspx',
        'used' => 'https://www.billbryanchryslerdodgejeep.com/searchused.aspx'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]*-[0-9]{4}-/i',
    //'use-proxy' => true,
    //'proxy-area'        => 'FL',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev'],
    'details_start_tag' => '<!-- Vehicle Start -->',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'model' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'trim' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)<\/li>\s*<li class="drive/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/Bill Bryan Price: <\/span><[^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Body Style<\/span>\s*<[^>]+>(?<body_style>[^<]+)/',
        'make' => '/var vehicleMake="(?<make>[^"]+)/',
        'model' => '/var vehicleModel="(?<model>[^"]+)/',
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/class="carousel__item js-carousel__item[^>]+><img src="(?<img_url>[^"]+)" alt="/',
);
//add_filter('filter_huffford_field_price', 'filter_huffford_field_price', 10, 3);
//
//function filter_huffford_field_price($price, $car_data, $spltd_data) {
//    $prices = [];
//
//    slecho('');
//
//    if ($price && numarifyPrice($price) > 0) {
//        $prices[] = numarifyPrice($price);
//        slecho("Internet Price: $price");
//    }
//
//    $msrp_regex = '/MSRP:\s*[^"]+"[^"]+"\s*>\$(?<price>[^<\/]+)/';
//    $retail_regex = '/Retail Price:\s*[^"]+"[^"]+"\s*>\$(?<price>[^<\/]+)/';
//
//    $matches = [];
//
//    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex MSRP: {$matches['price']}");
//    }
//    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//        $prices[] = numarifyPrice($matches['price']);
//        slecho("Regex Retail: {$matches['price']}");
//    }
//
//    if (count($prices) > 0) {
//        $price = butifyPrice(min($prices));
//    }
//
//    slecho("Sale Price: {$price}" . '<br>');
//    return $price;
//}
