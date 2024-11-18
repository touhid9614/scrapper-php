<?php

global $scrapper_configs;

$scrapper_configs['revolutionkia'] = array(
    'entry_points' => array(
        'new' => 'https://www.revolutionkia.ca/vehicle-category/new-inventory/',
        'used' => 'https://www.revolutionkia.ca/vehicle-category/used-inventory/'
    ),
    'vdp_url_regex' => '/\/cars\/[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slick-slide'],
    'picture_nexts' => ['.slick-next.slick-arrow'],
    'picture_prevs' => ['.slick-prev.slick-arrow'],
    'details_start_tag' => '<div class="listing',
    'details_end_tag' => '<footer',
    'details_spliter' => '<div class="car-grid ',
   'data_capture_regx' => array(
        'url' => '/<div class="car-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
        'price' => '/<span class="new-price">\s*&#036;(?<price>[^<]+)/',
        'year' => '/<div class="car-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
         'model' => '/<div class="car-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
         'make' => '/<div class="car-title">\s*<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
         'year' => '/Year[^>]+>[^>]+>(?<year>[^<]+)/',
         'model' => '/Model[^>]+>[^>]+>(?<model>[^<]+)/',
         'make' => '/Make[^>]+>[^>]+>(?<makel>[^<]+)/',
        'stock_number' => '/Stock Number<\/span>\s*[^>]+>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine<\/span>\s*<[^>]+>(?<engine>[^\<]+)/',
        'transmission' => '/Transmission<\/span>\s*<[^>]+>(?<transmission>[^\<]+)/',
        'kilometres' => '/Mileage<\/span>\s*<[^>]+>(?<transmission>[^\<]+)/',
        'body_style' => '/Body Style<\/span>\s*<[^>]+>(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/<a class="next page-numbers" href="(?<next>[^"]+)\//',
    'images_regx' => '/<img src="(?<img_url>[^"]+)"\s*class="img-responsive ps-car-listing" id="pscar-/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter('filter_revolutionkia_car_data', 'filter_revolutionkia_car_data');
function filter_revolutionkia_car_data($car_data) {
    //taking all cars except Corvette

  
    $car_data['model'] = str_replace('&#8211;', " – ", $car_data['model']);

   $car_data['title'] = str_replace('&#8211;', " - ", $car_data['title']);

    return $car_data;
}
