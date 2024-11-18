<?php
global $scrapper_configs;
$scrapper_configs["fremontchryslerdodgejeepcaspercom"] = array( 
	  "entry_points" => array(
        'new' => 'https://www.fremontchryslerdodgejeepcasper.com/car-dealership-casper-wy.html',
        'used' => 'https://www.fremontchryslerdodgejeepcasper.com/used-cars-casper-wy.html'
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['div.carousel__item img'],
    'picture_nexts' => ['.js-carousel__control--next'],
    'picture_prevs' => ['.js-carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<footer class=',
     'details_spliter' => '<div id="srpRow-',
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
        'price' => '/FREMONT PRICE:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:\s<\/strong>(?<kilometres>[^<]+)/',
        'vin' => '/VIN\s*#:\s*<\/strong><span>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'next_page_regx' => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="(?<img_url>[^"]+)height=[^"]+" alt="/'
);
add_filter("filter_fremontchryslerdodgejeepcaspercom_field_price", "filter_fremontchryslerdodgejeepcaspercom_field_price", 10, 3);

function filter_fremontchryslerdodgejeepcaspercom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
    $internet_regex = '/Internet Price\s*[^>]+>[^>]+>(?<price>\$[0-9,]+)/';
   

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
   
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
