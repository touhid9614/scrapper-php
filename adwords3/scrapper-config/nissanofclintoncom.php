<?php
global $scrapper_configs;
$scrapper_configs["nissanofclintoncom"] = array( 
	'entry_points' => array(
        'new' => 'https://www.nissanofclinton.com/nissan-dealer-clinton-nc.html?pn=100',
        'used' => 'https://www.nissanofclinton.com/used-cars-clinton-nc.html?pn=100',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)-[^-]+-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.carousel__image'],
    'picture_nexts' => ['.carousel__control--next'],
    'picture_prevs' => ['.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer class="full',
    'details_spliter' => '<div id="srpVehicle',
    'data_capture_regx' => array(
        'url' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        //  'title' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'year' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'make' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'model' => '/class="vehicleTitle[^>]+>\s*\s*<a.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]*))/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/Nissan of Clinton Price:\s*<\/span><span[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:\s<\/strong>(?<kilometres>[^<]+)/',
        'vin' => '/VIN\s*#:\s*<\/strong><span>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<a href="(?<next>[^"]+)"\s*>\s*Next/',
    'images_regx' => '/<div class="carousel__item--loupe js-loupe-element"><\/div>\s<[^>]+>\s*<img src="(?<img_url>[^?]+)/',
);
add_filter("filter_nissanofclintoncom_field_images", "filter_nissanofclintoncom_field_images");
add_filter("filter_nissanofclintoncom_field_price", "filter_nissanofclintoncom_field_price", 10, 3);

function filter_nissanofclintoncom_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'noimage_bertog.jpg');
    });
}

function filter_nissanofclintoncom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Final Price: $price");
    }

    $msrp_regex = '/MSRP[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
    $price_regex = '/Retail Price:[^>]+>[^>]+>(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
