<?php
global $scrapper_configs;
$scrapper_configs["capekiacom"] = array( 
	"entry_points" => array(
        'new' => 'https://www.capekia.com/new-kia-cape-girardeau-mo',
        'used' => 'https://www.capekia.com/used-vehicles-cape-girardeau-mo'
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    'refine'=>false,
    'picture_selectors' => ['.zoom-thumbnails__thumbnail'],
        'picture_nexts'     => ['.df-icon-chevron-right '],
        'picture_prevs'     => ['.df-icon-chevron-left'],
    
    'details_start_tag' => '<div class="inventory-listing',
    'details_end_tag' => '<footer class=',
    'details_spliter' => '<div class="vehicle-item inventory-listing__item',
    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'year' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'make' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'model' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'trim' => '/<a href="(?<url>[^"]+)"\s*class="js-vehicle-item-link[^>]+>\s*[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*<]+)/',
        'price' => '/Your Price\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/',
     
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/>Stock[^>]+>\s*[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'body_style' => '/Body Style[^>]+>\s*[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'kilometres' => '/Mileage[^>]+>\s*[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
        'year' => '/>Year[^>]+>\s*[^>]+>\s*[^>]+>(?<year>[0-9]{4})/',
        'make' => '/>Make[^>]+>\s*[^>]+>\s*[^>]+>(?<make>[^<]+)/',
        'model' => '/>Model<\/div>\s*[^>]+>\s*[^>]+>(?<model>[^<]+)/',
        'exterior_color' => '/Exterior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission' => '/>Transmission<\/div>\s*[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'drive_train' => '/>Drivetrain<\/div>\s*[^>]+>\s*[^>]+>(?<drive_train>[^<]+)/',
        'fuel_type' => '/>Fuel Type<\/div>\s*[^>]+>\s*[^>]+>(?<fuel_type>[^<]+)/',
        'vin' => '/>VIN<\/div>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
    ),
    'next_page_regx'    => '/<link rel="next" href="(?<next>[^"]+)"/',
     'images_regx'  => '/<picture><source data-srcset="(?<img_url>[^\s]+)\s*840w/',
    'images_fallback_regx' => '/<div class="thumb-preview">\s*<img src="(?<img_url>[^"]+)"/'
);
add_filter("filter_capekiacom_field_price", "filter_capekiacom_field_price", 10, 3);

function filter_capekiacom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $internet = '/Internet Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $msrp = '/MSRP\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';
    $retail = '/Advertised Price\s*[^>]+>\s*[^>]+>\s*(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($internet, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }
   if (preg_match($msrp, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex msrp: {$matches['price']}");
    }
    if (preg_match($retail, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex retail: {$matches['price']}");
    }
   
    
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}
