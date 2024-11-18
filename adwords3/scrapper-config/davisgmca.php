<?php
global $scrapper_configs;
$scrapper_configs["davisgmca"] = array( 
	"entry_points" => array(
	    'used' => 'https://www.davisgm.ca/used/',
        'new' => 'https://www.davisgm.ca/new/'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    
    'use-proxy' => true,
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.next-small'],
    'picture_prevs' => ['.left.left-small'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => '<footer class="opt-3 opt-custom wp"',
    'details_spliter' => '<div class="col-xs-12 col-sm-12 col-md-12">',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)"><span style/',
        'year'                => '/itemprop=\'releaseDate\'[^>]+>(?<year>[0-9]{4})/',
            'make'                => '/itemprop=\'manufacturer\'[^>]+>[^>]+>(?<make>[^\s*<]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>[^>]+>(?<model>[^\<]+)/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
        'engine' => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[^\s*]+)/',
        
    ),
    'data_capture_regx_full' => array(
       
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[^<]+<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx' => '/imgError\(this\)\;"\s*(?:src|data-src)="(?<img_url>[^"]+)"/'
);

add_filter("filter_davisgmca_field_price", "filter_davisgmca_field_price", 10, 3);

function filter_davisgmca_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }
    $old_regex = '/<span style="[^"]+"\s*itemprop="price" content="[^"]+">(?<price>[^\<]+)/';
    $msrp_regex = '/"final-price">(?<price>[^\<]+)/';
    $matches = [];

    if (preg_match($old_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex old price: {$matches['price']}");
    }

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');

    return $price;
}


