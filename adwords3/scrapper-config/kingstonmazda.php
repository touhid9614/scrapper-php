<?php

global $scrapper_configs;

$scrapper_configs['kingstonmazda'] = array(
    'entry_points' => array(
        'used' => 'https://www.kingstonmazda.ca/used/',
        'new' => 'https://www.kingstonmazda.ca/new/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['li.next'],
    'picture_prevs' => ['li.prev'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'>(?<year>[^<]+)/',
        'make' => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\'>(?<model>[^\<]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>\s*(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
        'vin' => '/itemprop="sku">(?<vin>[^\<]+)/',
        'drivetrain' => '/itemprop="vehicleDrivetrain">(?<drivetrain>[^<]+)/',
        'fuel_type' => '/itemprop="fuelType">\s*(?<fuel_type>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/'
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image"\s*content="(?<img_url>[^"]+)"/'
);

add_filter("filter_kingstonmazda_field_images", "filter_kingstonmazda_field_images");

function filter_kingstonmazda_field_images($im_urls) {
    if (count($im_urls) < 2) {
        return array();
    }



    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'no_image-640x480.jpg');
    });
}