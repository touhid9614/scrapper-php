<?php

global $scrapper_configs;

$scrapper_configs['registerchevrolet'] = array(
    'entry_points' => array(
        'new' => 'https://www.registerchevrolet.net/VehicleSearchResults?search=new',
        'used' => 'https://www.registerchevrolet.net/VehicleSearchResults?search=preowned',
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<ul each="cards">',
    'details_end_tag' => '<div class="content" id="pageDisclaimer">',
    'details_spliter' => '<div class="deck" each="cards">',
    'data_capture_regx' => array(
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)/',
        // 'stock_type'        => '/<a itemprop="url" .*\/VehicleDetails\/(?<stock_type>[^\-]+)/',
        'year' => '/itemprop="vehicleModelDate">(?<year>[0-9]{4})/',
        'make' => '/itemprop="manufacturer">(?<make>[^<]+)/',
        'model' => '/itemprop="model">(?<model>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'trim' => '/<span if="trim" class="trim"[^>]+>(?<trim>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)/',
        //  'interior_color'    => '/itemprop="vehicleInteriorColor" class="value">(?<interior_color>[^<]+)/',
        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
        'transmission' => '/itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
        'price' => '/data-action="priceSpecification" [^>]+>(?<price>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometeres>[^<]+)/',
        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^<]+)<\/span>/',
        'engine' => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
        'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span>/',
        //'price' => '/itemprop="price" data-action="priceSpecification" class="value " [^>]+>(?<price>[^<]+)/',
    ),
    'next_page_regx' => '/<a.*href="(?<next>[^"]+)"\s*data-action="pageNumber" rel="next"/',
    'images_regx' => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_registerchevrolet_next_page", "filter_registerchevrolet_next_page", 10, 2);
add_filter("filter_registerchevrolet_field_images", "filter_registerchevrolet_field_images");

function filter_registerchevrolet_next_page($next, $current_page) {
    slecho("Filtering Next url");
    $car_type = explode('=', $current_page);
    return urlCombine($next, "?search={$car_type[count($car_type) - 1]}");
}

add_filter("filter_registerchevrolet_field_price", "filter_registerchevrolet_field_price", 10, 3);

function filter_registerchevrolet_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("acuraofseattle Price: $price");
    }

    $msrp_regex = '/<span itemprop="price" class="value " value="[^>]+>(?<price>[^<]+)/';
    $now_regex = '/Now:\s*(?<price>\$[0-9,]+)/';
    $list_regex = '/List Price:\s*(?<price>\$[0-9,]+)/';

    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (preg_match($now_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Now: {$matches['price']}");
    }

    if (preg_match($list_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex List Price: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

function filter_registerchevrolet_field_images($im_urls)
{
    $final_image=[];
    $i = 0;
    foreach ($im_urls as $images){
        if ($i < 2) {
            $i += 1;
            continue;
        }
        array_push($final_image,$images);
    }
    return $final_image;
}
