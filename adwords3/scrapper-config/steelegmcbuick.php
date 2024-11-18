<?php

global $scrapper_configs;

$scrapper_configs['steelegmcbuick'] = array(
     'entry_points' => array(
        'new' => 'https://www.steelegmcbuick.com/VehicleSearchResults?search=new',
        'used' => 'https://www.steelegmcbuick.com/VehicleSearchResults?search=preowned',
   
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/',
    'use-proxy' => true,
      'refine'=>false,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['div.arrow.single.next'],
    'picture_prevs' => ['div.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
       
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',       
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
         'stock_number' => '/class="value" itemprop="sku">(?<stock_number>[^<]+)/',
         'vin'              => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',  
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'engine' => '/"key">Engine Data[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/key">Transmission[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/key">Exterior Color[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/key">Interior Color[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
    ),
     'next_page_regx'        => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/<meta itemprop="image" content="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_steelegmcbuick_next_page", "filter_steelegmcbuick_next_page", 10, 2);
add_filter('filter_steelegmcbuick_field_price', 'filter_steelegmcbuick_field_price', 10, 3);

function filter_steelegmcbuick_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

add_filter("filter_steelegmcbuick_field_price", "filter_steelegmcbuick_field_price", 10, 3);

function filter_steelegmcbuick_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/itemprop="name">MSRP[^\$]+(?<price>[^<]+)/';
   

    $matches = [];

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

