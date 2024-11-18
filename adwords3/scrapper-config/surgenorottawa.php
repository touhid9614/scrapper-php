<?php

global $scrapper_configs;
$scrapper_configs["surgenorottawa"] = array(
    'entry_points' => array(
        'new' => 'https://www.surgenorottawa.com/en/new-inventory',
        'used' => 'https://www.surgenorottawa.com/en/used-inventory'
    ),
    'picture_selectors' => ['.overlay img'],
    'picture_nexts' => ['.bx-wrapper__small-next'],
    'picture_prevs' => ['.bx-wrapper__small-prev'],
    'vdp_url_regex' => '/\/en\/(?:new|used)-inventory\//i',
    'use-proxy' => true,
    'details_start_tag' => '<div class="inventory-listing__vehicles',
    'details_end_tag' => '<p class="inventory-listing__disclaimer smallprint"',
    'details_spliter' => 'class="inventory-preview-juliette__wrapper',
    'data_capture_regx' => array(
        'stock_number' => '/inventory-preview-juliette__preview-stock-number"[^>]+>\s*#\s*(?<stock_number>[^<]+)/',
        'title' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'year' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'make' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'model' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'price' => '/inventory-preview-juliette__preview-price-current[^>]+>\s*(?<price>\$[0-9,]+)/',
        'url' => '/inventory-preview-juliette__preview-name"\s*href="(?<url>[^"]+)"\s*itemprop="url"\s*title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)[^"]+)"/',
        'kilometres' => '/inventory-preview-juliette__preview-info-picto[^>]+>[^>]+>\s*[^>]+>(?<kilometres>[^\<]+)/',
    ),
    'data_capture_regx_full' => array(
       // 'body_style' => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        //'engine'        => '/engine-type">\s*[^\n]+\s*(?<engine>[^\n]+)/',
        'transmission' => '/inventory-details__vehicle-info-value">\s*(?<transmission>[^\<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>\s*.*inventory-details__content-value[^>]+>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Int. color:[^>]+>\s*.*inventory-details__content-value[^>]+>(?<interior_color>[^\<]+)/',
    ),
   'next_page_regx'    => '/<a class="pagination__page-arrows-text " href="(?<next>[^"]+)"[^>]+>\s*<i data-theme-sprite="simple-arrow-right">/',
    'images_regx' => '/<span class="overlay">\s*<img (?:class="[^"]+"|)\s*src="(?<img_url>[^"]+)/',
);

add_filter("filter_surgenorottawa_field_images", "filter_surgenorottawa_field_images");
function filter_surgenorottawa_field_images($im_urls) {
    if(count($im_urls) < 2) { return array(); }
    return array_filter($im_urls, function($img_url) {
        return !endsWith($img_url, "notfound.jpg");
    }
    );
}
