<?php
global $scrapper_configs;
$scrapper_configs["palmengmcom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.palmengm.com/new-vehicles-kenosha-wi?limit=300',
        'used' => 'https://www.palmengm.com/used-vehicles-kenosha-wi?limit=300',
    ),
     'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    
        'picture_selectors' => ['.zoom-thumbnails__thumbnail'],
        'picture_nexts'     => ['.df-icon-chevron-right '],
        'picture_prevs'     => ['.df-icon-chevron-left'],
    
    'details_start_tag' => '<div class="inventory-listing vehicle-items',
    'details_end_tag' => '<footer class=',
    'details_spliter' => '<div class="vehicle-item inventory-listing__item',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*class="[^>]+>\s*<h6 class="vehicle-item__title[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'year' => '/<a href="(?<url>[^"]+)"\s*class="[^>]+>\s*<h6 class="vehicle-item__title[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'make' => '/<a href="(?<url>[^"]+)"\s*class="[^>]+>\s*<h6 class="vehicle-item__title[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'model' => '/<a href="(?<url>[^"]+)"\s*class="[^>]+>\s*<h6 class="vehicle-item__title[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'trim' => '/<a href="(?<url>[^"]+)"\s*class="[^>]+>\s*<h6 class="vehicle-item__title[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'price' => '/Palmen Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
         'kilometres' => '/Mileage:[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
         'engine' => '/Engine:[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/>Body Style[^>]+>\s*[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'stock_number' => '/Stock">\s*[^>]+>\s*#\s*(?<stock_number>[^\s*]+)/',
        'vin' => '/VIN:[^>]+>\s*[^>]+>(?<vin>[^<]+)/', 
        'exterior_color' => '/>Exterior Color[^>]+>[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/>Interior Color[^>]+>[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission' => '/>Transmission<\/div>[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
    ),
    //'next_page_regx'    => '/<link rel="next" href="(?<next>[^"]+)"/',
  //   'images_regx'  => '/spect-ratio-block_inner">\s*<picture><source srcset="(?<img_url>[^\s]+)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
add_filter("filter_palmengmcom_field_price", "filter_palmengmcom_field_price", 10, 3);

function filter_palmengmcom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/Palmen Price\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<price>[^<]+)/';
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
