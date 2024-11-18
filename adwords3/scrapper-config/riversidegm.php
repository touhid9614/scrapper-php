<?php

global $scrapper_configs;

$scrapper_configs['riversidegm'] = array(
    'entry_points' => array(
        'new' => 'https://www.riversidegmbrockville.com/VehicleSearchResults?search=new',
        'used' => 'https://www.riversidegmbrockville.com/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<section id="card-view/card/d7e8bf5e-ef26-4db5-93ce-a98b9c6b7b31-',
    'data_capture_regx' => array(
        // 'stock_number'      => '/itemprop="sku">(?<stock_number>[^<]+)/',
        'stock_number' => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
        'stock_type' => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/Riverside Price<\/span>\s*<span itemprop="price" class="value ">(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
        'certified' => '/"vehicle":\{"category":"(?<certified>certified)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/'
    ),
    'next_page_regx' => '/data-action="next" href="(?<next>[^"]+)"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_riversidegm_next_page", "filter_riversidegm_next_page", 10, 2);
add_filter("filter_riversidegm_field_price", "filter_riversidegm_field_price", 10, 3);

function filter_riversidegm_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

function filter_riversidegm_field_price($price, $car_data, $spltd_data) {

    if ($car_data['stock_type'] == "new") {

        $msrp_regex = '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/';


        $matches = [];

        if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
            $price = numarifyPrice($matches['price']);
            slecho("Regex MSRP: {$matches['price']}");
        }



        $price = butifyPrice($price);


        slecho("Sale Price: {$price}" . '<br>');
        return $price;
    } else {
        return $price;
    }
}
