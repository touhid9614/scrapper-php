<?php
global $scrapper_configs;
$scrapper_configs["hondaofcartersvillecom"] = array( 
	"entry_points" => array(
	     'new' => 'https://www.hondaofcartersville.com/new-honda-for-sale',
        'used' => 'https://www.hondaofcartersville.com/used-cars-for-sale'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
   
    'use-proxy' => true,
   
    'picture_selectors' => ['.magic-thumbs ul li', '.slick-slide',],
    'picture_nexts' => ['.mz-button.mz-button-next'],
    'picture_prevs' => ['.mz-button.mz-button-prev'],

    'details_start_tag' => '<div class="large-9 columns srp-results">',
    'details_end_tag' => '<div class="footer">',
    'details_spliter' => '<div class="row srp-vehicle"',

    'data_capture_regx' => array(
        'stock_number' => '/Stock:<\/span>\s*<span>(?<stock_number>[^<]+)/',
        'title' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'year' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'make' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'model' => '/<span itemprop=\'name\'>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)\s*[^<]*)/',
        'price' => '/Internet Price:<\/span><[^>]+><[^>]+>[^>]+><[^>]+><\/span>(?<price>[^<]+)/',
        'engine' => '/Engine:<\/span>\s*(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>\s*(?<transmission>[^<]+)/',
        'kilometres' => '/Mileage:<\/span>\s*(?<kilometres>[^<]+)/',
        'exterior_color' => '/Ext. Color:\s*<\/span>\s*(?<exterior_color>[^<]+)<\/div>/',
        'url' => '/srp-vehicle-title">\s*<a href="(?<url>[^"]+)/',
        'interior_color' => '/Int. Color:<\/span>\s*(?<interior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
       
    ),
    'next_page_regx' => '/current\'><a[^>]+>[^<]+<\/a><\/li><li><a href=\'\/inventory(?<next>[^\']+)/',
    'images_regx' => '/vehicleGallery" href="(?<img_url>[^"]+)/',
);

add_filter("filter_hondaofcartersvillecom_field_price", "filter_hondaofcartersvillecom_field_price", 10, 3);

function filter_hondaofcartersvillecom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/MSRP:<\/span><[^>]+><[^>]+><[^>]+>[^>]+><[^>]+><\/span>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/stackedConditionalFinal"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';
    $retail_regex = '/retailValue"[^>]+>\s*<strong[^>]+>(?<price>[^<]+)/';
    $asking_regex = '/askingPrice"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/';


    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }
    if (preg_match($wholesale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex wholesale: {$matches['price']}");
    }
    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }

    if (preg_match($cond_final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Conditional Price: {$matches['price']}");
    }

    if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Retail Price: {$matches['price']}");
    }
    if (preg_match($asking_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Asking Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
