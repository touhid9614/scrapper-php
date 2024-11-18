<?php
global $scrapper_configs;
$scrapper_configs["sutherlinnissanftmyerscom"] = array( 
	'entry_points' => array(
            'new'   => 'https://sutherlinnissanftmyers.com/new-nissan-for-sale',
            'used'  => 'https://sutherlinnissanftmyers.com/used-cars-for-sale'
        ),
        'vdp_url_regex'       => '/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'=> false,
        'picture_selectors' => ['.magic-thumbs'],
        'picture_nexts'     => ['.mz-button.mz-button-next'],
        'picture_prevs'     => ['.mz-button.mz-button-prev'],
     
         'details_start_tag' => '<div class="srp-vehicle-container" >',
         'details_end_tag' => '<div class="footer">',
         'details_spliter' => '<div class="row srp-vehicle"',
        'data_capture_regx' => array(
        'stock_number' => '/Stock:<\/span>\s*(?<stock_number>[^<]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'price' => '/(?:Best Price|Your Price):[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
        'exterior_color' => '/Ext. Color:<\/span>\s*(?<exterior_color>[^<]+)/',
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'interior_color' => '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'make' => '/make":\s*"(?<make>[^"]+)/',
        'model' => '/model":\s*"(?<model>[^"]+)/',
        'trim' => '/trim":\s*"(?<trim>[^"]+)/',
    ),
    'next_page_regx' => '/current\'><a[^>]+>[0-9]+<\/a><\/li><li><a href=\'\/inventory(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_sutherlinnissanftmyerscom_field_price", "filter_sutherlinnissanftmyerscom_field_price", 10, 3);

function filter_sutherlinnissanftmyerscom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/';
    $market_regex = '/Market Price:[^\$]+\$.*itemprop=\'price\' content=\'(?<price>[^\']+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($market_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Market: {$matches['price']}");
    }
    
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
