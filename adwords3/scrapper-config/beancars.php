<?php

global $scrapper_configs;

$scrapper_configs['beancars'] = array(
    'entry_points' => array(
        'used' => 'https://www.beancars.ca/used/',
        'new' => 'https://www.beancars.ca/new/',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)\/vehicle\/[0-9]{4}-/i',
    'use-proxy'              => true,
    'refine'                 => false,
    'picture_selectors'      => ['.thumb li'],
    'picture_nexts'          => ['.next'],
    'picture_prevs'          => ['.prev'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag' => 'class="modal-footer">',
    'details_spliter' => '<input type="hidden" style="display:none;" id="vehicle_owner_dealer_id',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)" title="/',  
        'year' => '/itemprop=\'releaseDate[^>]+>(?<year>[0-9]+)/',
        'make' => '/itemprop=\'manufacturer[^>]+>[^>]+>(?<make>[0-9a-zA-Z\s]+)/',
        'model' => '/itemprop=\'model[^>]+>[^>]+>(?<model>[0-9a-zA-Z\s]+)/',
        'price' => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
        'kilometres' => '/itemprop="mileageFromOdometer".+>(?<kilometres>[0-9,]+\skm)<\/span>/',
        'stock_number' => '/Stock #:[^>]+>[^>]+>\s*(?<stock_number>[^<]+)/',
        'engine' => '/itemprop="vehicleEngine">(?<engine>.+cyl)<\/td>/',
        'body_style' => '/itemprop="bodyType">(?<body_style>[0-9a-zA-Z\s]+)<\/td><\/tr>/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[0-9a-zA-Z\s]+)<\/td><\/tr>/',
        'exterior_color' => '/itemprop="color"\s+>(?<exterior_color>[a-zA-Z]+)<\/td><\/tr>/',
    ),
    
  'data_capture_regx_full' => array(
        // 'model' => '/\&model=(?<model>[^\&]+)/',
        // 'trim' => '/\&trim=(?<trim>[^\&]+)/',
        'stock_number'        => '/itemprop="sku">\s*(?<stock_number>[^\<]+)/',
        'engine'              => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
        'body_style'          => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
        'transmission'        => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
        'exterior_color'     =>  '/itemprop="color"\s*>\s*(?<exterior_color>[^\<]+)/',
      ),  
    
    'next_page_regx' => '/rel="next"\shref="(?<next>[^"]+)"/',
    'images_regx' => '/data-src="(?<img_url>[^"]*)/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_beancars_field_price", "filter_beancars_field_price", 10, 3);
add_filter("filter_beancars_field_images", "filter_beancars_field_images");

function filter_beancars_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("beancars Price: $price");
    }

    $msrp_regex = '/MSRP:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
    $suggested_regex = '/Suggested Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
    $final_regex = '/Final Price:<\/span>\s*<span[^>]+><meta[^>]+><span[^>]+>(?<price>\$[0-9,]+)/';
    $price_regex = '/>Price:<\/span>\s*<span[^>]+>[\S\s]+?itemprop="price"[^>]+>(?<price>\$[0-9,]+)/';
    $internet_regex = '/Our Price:<\/span>\s*<span[^>]+>[\S\s]+?itemprop="price"[^>]+>(?<price>\$[0-9,]+)/';
    $matches = [];

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (preg_match($suggested_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex suggested: {$matches['price']}");
    }

    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex final: {$matches['price']}");
    }

    if (preg_match($price_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex price: {$matches['price']}");
    }

    if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex internet: {$matches['price']}");
    }
    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}

function filter_beancars_field_images($im_urls) {
    return array_filter($im_urls, function($im_url) {
        return !endsWith($im_url, 'new_vehicles_images_coming.png');
    });
}


add_filter("filter_beancars_field_description", "filter_beancars_field_description");

function filter_beancars_field_description($description) {
    $description = str_replace("&nbsp;", " ", $description);
    $description = str_replace("Read Less", "", $description);
    return strip_tags($description);
}
