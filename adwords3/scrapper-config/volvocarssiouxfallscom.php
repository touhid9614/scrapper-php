<?php
global $scrapper_configs;
$scrapper_configs["volvocarssiouxfallscom"] = array( 
	"entry_points" => array(

	    'new' => 'https://www.volvocarssiouxfalls.com/new-inventory/index.htm',
        'used' => 'https://www.volvocarssiouxfalls.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel-item'],
    'picture_nexts' => ['.imageScrollNext.next'],
    'picture_prevs' => ['.imageScrollPrev.previous'],
    'details_start_tag' => '<ul class="gv-inventory-list simple-grid list-unstyled">', 
    'details_end_tag' => '<div  class="ddc-footer">',
    'details_spliter' => '<li class="item hproduct clearfix',
    'data_capture_regx' => array(
        'stock_number' => '/Stock Number<\/label>\s*<span>(?<stock_number>[^<]+)/',
        'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'engine' => '/Engine<\/label>\s*<span>(?<engine>[^<]+)/',
        'kilometres' => '/Mileage<\/label>\s*<span>(?<kilometres>[^<]+)/',
        'transmission' => '/Transmission<\/label>\s*<span>(?<transmission>[^<]+)/',
        'interior_color' => '/Interior Color<\/label>\s*<span>(?<interior_color>[^<]+)/',
         'url' => '/class="inventory-titl[^>]+>\s*<a href="(?<url>[^"]+)[^>]+>(?<title>[^<]+)/',
         'title' => '/class="inventory-titl[^>]+>\s*<a href="(?<url>[^"]+)[^>]+>(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'exterior_color' => '/Exterior Color<\/label>\s*<span>(?<exterior_color>[^<]+)/',
        'price' => '/finalPrice.*>\s*<span class="[^>]+>.*\s*<span class="[^>]+>\s*(?<price>\$[0-9,]+)/',
      ),

      'data_capture_regx_full' => array(
           
            'price' => '/(?:Price|Sale Price)<\/span><\/dt><[^>]+><[^>]+>\s*(?<price>\$[0-9,]+)/',
            'stock_type'        => '/vehicleType:\s*\'(?<stock_type>[^\']+)/',
        ) ,
    'next_page_regx' => '/next-btn" data-href="(?<next>[^"]+)"/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_volvocarssiouxfallscom_field_price", "filter_volvocarssiouxfallscom_field_price", 10, 3);

function filter_volvocarssiouxfallscom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/wholesalePrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $internet_regex = '/internetPrice">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $cond_final_regex = '/Conditional Final Price\s*<[^>]+>:<\/span>\s*<\/span>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/';
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

add_filter("filter_volvocarssiouxfallscom_field_stock_type", "filter_volvocarssiouxfallscom_field_stock_type");
function filter_volvocarssiouxfallscom_field_stock_type($stock_type) {
    return strtolower($stock_type);
}