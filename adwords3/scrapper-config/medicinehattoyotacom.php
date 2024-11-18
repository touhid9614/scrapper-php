<?php
global $scrapper_configs;
$scrapper_configs["medicinehattoyotacom"] = array( 
	 'entry_points' => array(
        'used'  => 'https://www.medicinehattoyota.com/inventory.html?filterid=q0-500',
      
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/.*[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.slide a img'],
    'picture_nexts' => ['div a.next'],
    'picture_prevs' => ['div a.previous'],
    'details_start_tag' => '<div class="divSpan divSpan12 lstListingWrapper">',
    'details_end_tag' => '<div id="footerWrapper"',
    'details_spliter' => '<li class="carBoxWrapper"',
    'data_capture_regx' => array(
        'url' => '/class="divSpan carTitle">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'title' => '/class="divSpan carTitle">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'year' => '/class="divSpan carTitle">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'make' => '/class="divSpan carTitle">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'model' => '/class="divSpan carTitle">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
        'price' => '/class="divSpan carPrice elIsLoadable">\s*<span [^>]+>(?<price>[0-9,]+)/',
        'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
    ),
    'data_capture_regx_full' => array(
        'stock_type' => '/specsNoStock[^\:]*\:[^-]+-[A-Za-z0-9]+-(?<stock_type>new)/',
        'stock_number' => '/specsNoStock[^\:]*\:(?<stock_number>[^<]+)/',
        'kilometres' => '/Kilometers:\s(?<kilometres>[0-9 ,]+)/',
        'engine' => '/Engine:\s(?<engine>[^<]+)/',
        'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
        'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
        'vin'            => '/specsNoStock[^\:]*\:(?<vin>[^<]+)/',
        'body_style' => '/specsBodyType\'>Category:\s*(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '//',
    'images_regx' => '/<a rel="slider-lightbox[^"]+"\shref="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta property="og:image"content="(?<img_url>[^"]+)/'
);


add_filter("filter_medicinehattoyotacom_field_images", "filter_medicinehattoyotacom_field_images");
add_filter('filter_medicinehattoyotacom_car_data', 'filter_medicinehattoyotacom_car_data');


function filter_medicinehattoyotacom_car_data($car_data) {
    //taking all cars except Corvette

    $car_data['exterior_color'] = str_replace('&agrave;', '', $car_data['exterior_color']);
    $car_data['transmission']   = str_replace('&agrave;', '', $car_data['transmission']);
   

    return $car_data;
}
