<?php

global $scrapper_configs;

$scrapper_configs['peninsulaford'] = array(
    'entry_points' => array(
        'new' => 'https://www.peninsulaford.com/new/',
        'used' => 'https://www.peninsulaford.com/used/'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="footer wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year' => '/itemprop=\'releaseDate\'>(?<year>[0-9]{4})/',
        'make' => '/itemprop=\'manufacturer\'>(?<make>[^\<]+)/',
        'model' => '/itemprop=\'model\'>(?<model>[^\<]+)/',
        'trim' => '/"trim":"(?<trim>[^"]+)"/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^<]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
    
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
        'price' => '/<span id="final-price">(?<price>[^\<]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^>]+><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*src="(?<img_url>[^"]+)/'
);

add_filter("filter_peninsulaford_field_images", "filter_peninsulaford_field_images");
//add_filter("filter_autoparktoronto_field_stock_number", "filter_autoparktoronto_field_stock_number");

function filter_peninsulaford_field_images($im_urls) {
     if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
}
//
//function filter_autoparktoronto_field_stock_number($stock_number) {
//    if ($stock_number == 'N/A') {
//        $stock_number = '';
//    }
//    return $stock_number;
//}
