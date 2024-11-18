<?php

global $scrapper_configs;
$scrapper_configs["cowboykiacom"] = array(
    'entry_points' => array(
        'new' => 'https://www.cowboykia.com/inventory?type=new',
        'used' => 'https://www.cowboykia.com/inventory?type=used'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
	'use-proxy' => true,
	
    'picture_selectors' => ['.slick-slide',],
    'picture_nexts' => ['.mz-button.mz-button-prev'],
	'picture_prevs' => ['.mz-button.mz-button-next'],
	
    'details_start_tag' => '<div class="srp-vehicle-container" >',
    'details_end_tag' => '<div class="footer">',
	'details_spliter' => '<div class="row srp-vehicle" itemprop="offers"',
	
    'data_capture_regx' => array(
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^\s*]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^\s*]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^\s*]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^\s*]*)/',
        'stock_number' => '/<div class="column"><span>Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'price' => '/itemprop=\'price\'\s*[^>]+><[^>]+>(?<price>[^<]+)/',
        'exterior_color' => '/<div class="column"><span>Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/<div class="column"><span>Ext. Color:<\/span>\s*(?<interior_color>[^<]+)/',
		'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
		'vin' => '/">VIN[^>]+>\s*(?<vin>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/'
    ),
    'data_capture_regx_full' => array(
        'make' => '/make":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/trim":\s*"(?<trim>[^"]+)/',
        'body_style' => '/Body Style:<\/span>\s*(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/current\'><a[^>]+>[^<]+<\/a><\/li><li><a href=\'(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
);
add_filter("filter_cowboykiacom_field_price", "filter_cowboykiacom_field_price", 10, 3);
function filter_cowboykiacom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }
    $final_regex = '/Sale Price:[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';//final price
    $msrp_regex = '/MSRP[^>]+>[^>]+>[^>]+>\$[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/'; 
    $internet_regex = '/Carlock Price:[^>]+>[^>]+>[^>]+>\$[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';
  


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Final price: {$matches['price']}");
    }

      if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Internet Price: {$matches['price']}");
    }
    

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
