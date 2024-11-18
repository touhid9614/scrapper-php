<?php

global $scrapper_configs;

$scrapper_configs['stankinggmsuperstore'] = array(
    'entry_points' => array(
        'new' => 'https://www.stankinggmsuperstore.com/searchnew.aspx',
        'used' => 'https://www.stankinggmsuperstore.com/searchused.aspx',
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}-/i',
    'ty_url_regex' => '/\/thankyou.aspx/i',
    'picture_selectors' => ['.carousel__item'],
    'picture_nexts' => ['div.carousel__control--next'],
    'picture_prevs' => ['div.carousel__control--prev'],
    'details_start_tag' => '<div class="col-md-9 sidebar-oncanvas">',
    'details_end_tag' => '<div class="row srpDisclaimer">',
    'details_spliter' => '<div id="srpRow-',
    'data_capture_regx' => array(
        'vin'           => '/VIN #:\s*[^>]+>[^>]+>(?<vin>[^<]+)/',
        'url' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'title' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'year' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'make' => '/class="vehicleTitle\s*margin-[^>]+>\s*<a\s*.*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*(?<trim>[^<]*))/',
        'model' => '/class="notranslate">(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ ]+) (?<trim>[^<]+)/',
        'body_style' => '/<strong>Body\s*Style:\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<]+)/',
        'engine' => '/<strong>Engine:\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/<strong>Ext.\s*Color:\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/<strong>Int.\s*Color:\s*[^>]+>(?<interior_color>[^<]+)/',
        'stock_number' => '/<strong>Stock\s*#:\s*[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/<strong>Mileage\s*[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/class="pull-right primaryPrice">(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/brand":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/var vehicleTrim="(?<trim>[^"]+)/'
    ),
    'next_page_regx' => '/rel="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/'
);




     add_filter("filter_stankinggmsuperstore_field_images", "filter_stankinggmsuperstore_field_images");

        function filter_stankinggmsuperstore_field_images($im_urls)
        {
            return array_filter($im_urls, function($im_url){
                return !endsWith($im_url, 'photo_unavailable_640.png');
            });
        }





add_filter('filter_stankinggmsuperstore_field_price', 'filter_stankinggmsuperstore_field_price', 10, 3);

function filter_stankinggmsuperstore_field_price($price, $car_data, $spltd_data) {
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
