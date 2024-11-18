<?php

global $scrapper_configs;
$scrapper_configs["northwestridescom"] = array(
    'entry_points' => array(
        'used' => 'https://www.northwestrides.com/used-inventory/pageSizeChange/1/10/~/VehicleType_~Make_~Comment1_~Year_~Price1_~Mileage_~EPAHighway_~TransmissionGeneric_~ExteriorColor_/~/100',
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)-inventory\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.carousel-inner'],
    'picture_nexts' => ['.glyphicon.glyphicon-chevron-right'],
    'picture_prevs' => ['.glyphicon.glyphicon-chevron-left'],
    'details_start_tag' => '<div id="browse">',
    'details_end_tag' => '<footer id="footer">',
    'details_spliter' => 'class="browse-row',
    'data_capture_regx' => array(
        'url' => '/value="(?<url>[^"]+)"><div class="row">/',
        'title' => '/text-center">\s*<h4 class="hidden[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'year' => '/text-center">\s*<h4 class="hidden[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/text-center">\s*<h4 class="hidden[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/text-center">\s*<h4 class="hidden[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'stock_number' => '/Stock Number:<\/span><[^>]+>(?<stock_number>[^<]+)/',
        'kilometres' => '/Mileage:<\/span><[^>]+>(?<kilometres>[^<]+)/',
        'price' => '/Internet Price:<\/span><[^>]+>(?<price>\$[0-9,]+)/',
        'exterior_color' => '/Exterior Color:<\/span><[^>]+>(?<exterior_color>[^<]+)/',
        'engine' => '/Engine:<\/span><[^>]+>(?<engine>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'vin' => '/VIN:<\/span><[^>]+>(?<vin>[^<]+)/',
        'price' => '/Special Price:<\/span><[^>]+>(?<price>\$[0-9,]+)/',
        'transmission' => '/Transmission:<\/span><[^>]+>(?<transmission>[^<]+)/',
        'interior_color' => '/Interior Color:<\/span><[^>]+>(?<interior_color>[^<]+)/',
    ),
    // 'next_page_regx' => '/<a class="pagination__page-arrows-text\s"\shref="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
    'images_regx' => '/class="item"[^>]+><img src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter("filter_northwestrides_field_price", "filter_northwestrides_field_price", 10, 3);

function filter_northwestrides_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/msrp">.*class=\'value[^>]+>(?<price>[^<]+)/';
    $wholesale_regex = '/Special Price:<\/span><[^>]+>(?<price>\$[0-9,]+)/';
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
