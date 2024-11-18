<?php
global $scrapper_configs;
$scrapper_configs["carlislegmcom"] = array( 
	   'entry_points' => array(
        'new' => 'https://www.carlislegm.com/searchnew.aspx',
        'used' => 'https://www.carlislegm.com/searchused.aspx'
    ),
     'vdp_url_regex' => '/\/(?:new|used|certifierd)-[^-]+-[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['div.carousel__control--next'],
    'picture_prevs' => ['div.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle margin-x">\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)[^\n<]*)/',
        'title' => '/class="vehicleTitle margin-x">\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)[^\n<]*)/',
        'year' => '/class="vehicleTitle margin-x">\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)[^\n<]*)/',
        'make' => '/class="vehicleTitle margin-x">\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)[^\n<]*)/',
        'model' => '/class="vehicleTitle margin-x">\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)[^\n<]*)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/class="pull-right primaryPrice">(?<price>\$[0-9,]+)/',
        'body_style' => '/Body Style:\s*<\/strong>(?<body_style>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);


add_filter("filter_carlislegmcom_field_price", "filter_carlislegmcom_field_price", 10, 3);
function filter_carlislegmcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>(?<price>[^<]+)/';  ///msrp//
    $sale_regex = '/Sale Price[^>]+>:[^>]+>[^>]+>[^>]+>(?<price>[^<]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
  
    if (preg_match($sale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

