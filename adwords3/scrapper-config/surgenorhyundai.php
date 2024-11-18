<?php

global $scrapper_configs;
$scrapper_configs["surgenorhyundai"] = array(
    'entry_points' => array(
        'new' => 'https://www.surgenorhyundai.com/en/new-inventory?limit=112&page=1',
        'used' => 'https://www.surgenorhyundai.com/en/used-inventory?limit=33&page=1'
    ),
    'picture_selectors' => ['.overlay img'],
    'picture_nexts' => ['.bx-wrapper__small-next'],
    'picture_prevs' => ['.bx-wrapper__small-prev'],
    'vdp_url_regex' => '/\/en\/(?:new|used)-inventory\//i',
    'use-proxy' => true,
    'details_start_tag' => '<div class="inventory-listing__vehicles',
    'details_end_tag' => '<span id="price-legal">',
    'details_spliter' => '<article class="inventory-preview-juliette"',
    'data_capture_regx' => array(
        'stock_number' => '/inventory-preview-juliette__preview-stock-number".*#\s*(?<stock_number>[^<]+)/',
        'year' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'make' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'model' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'price' => '/inventoryPreviewPrice_fontColor">\s*(?<price>\$[0-9,]+)/',
        'url' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'kilometres' => '/data-theme-sprite="km">[^>]+>\s*[^>]+>">(?<kilometres>[0-9 ,]+)/',
    ),
    'data_capture_regx_full' => array(
        'exterior_color' => '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^\<]+)/',
        'model' => 'data-desired-model="(?<model>[^"]+)"',
        //'body_style' => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/Transmission[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
    ),
    'next_page_regx' => '/<a class="pagination__page-button-text " href="(?<next>[^"]+)"/',
    'images_regx' => '/(?:overlay|inventory-details__header-main-picture--center)">\s*<img (?:class="[^"]+"|)\s*src="(?<img_url>[^"]+)"\s*alt="/',
);

add_filter("filter_surgenorhyundai_field_price", "filter_surgenorhyundai_field_price", 10, 3);

function filter_surgenorhyundai_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho(" Price: $price");
    }

    $msrp_regex = '/smallprint">MSRP[^>]+>\s*[^>]+>\s*(?<price>[^<]+)/';

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
