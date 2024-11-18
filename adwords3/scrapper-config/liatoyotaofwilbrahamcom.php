<?php

global $scrapper_configs;
$scrapper_configs["liatoyotaofwilbrahamcom"] = array(
    "entry_points" => array(
        'new' => 'https://www.liatoyotaofwilbraham.com/searchnew.aspx?Dealership=Lia%20Toyota%20of%20Wilbraham',
        'used' => 'https://www.liatoyotaofwilbraham.com/searchused.aspx?Dealership=Lia%20Toyota%20of%20Wilbraham',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['.carousel__control.carousel__control--next'],
    'picture_prevs' => ['.carousel__control.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'stock_type' => '/data-vehicletype="(?<stock_type>[^"]+)/',
        'url' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'title' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'year' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'make' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        'model' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^<]+))/',
        ///'trim' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*(?<trim>[^<]+))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<\/]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)<\/li>\s*<li class="drive/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<\/]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<\/]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<\/]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<\/]+)/',
        'price' => '/Our Price:\s*<\/span><[^>]+>(?<price>[^<]+)/',
        'vin' => '/<strong>VIN\s*#:\s*<\/strong>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)" class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
);
add_filter('filter_liatoyotaofwilbrahamcom_field_price', 'filter_liatoyotaofwilbrahamcom_field_price', 10, 3);

function filter_liatoyotaofwilbrahamcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Internet Price: $price");
    }

    $msrp_regex = '/MSRP:\s*<\/span><[^>]+>(?<price>[^<]+)/';
    $retail_regex = '/NADA Book Value:\s*<\/span><[^>]+>(?<price>[^<]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
