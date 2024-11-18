<?php

global $scrapper_configs;
$scrapper_configs["macdonaldkiaca"] = array(
    'entry_points' => array(
        'new' => 'https://www.macdonaldkia.ca/en/for-sale/all/new',
        'used' => 'https://www.macdonaldkia.ca/en/for-sale/all/used'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:inventory\/)?(?:new|used)/i',
    'ty_url_regex' => '/\/thank-you/i',
    'ajax_url_match' => '/confirm-availability/',
    'ajax_resp_match' => 'Thank You For Your Inquiry - MacDonald Auto Group',
    'picture_selectors' => ['.inventory-vehicle-details__header-gallery-item-img'],
    'picture_nexts' => ['.controls__btn.nextPage'],
    'picture_prevs' => ['.controls__btn.prevPage'],
   // 'details_start_tag' => '<div class="inventory-list__vehicles',
   // 'details_end_tag' => '<div class="footer__topblock footer-wrapper">',
    'details_spliter' => '<article class="block-inventory-vehicle block-inventory-vehicle',
    'data_capture_regx' => array(
        'title' => '/<a class="inventory-vehicle__name" href="(?<url>[^"]+)" title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'year' => '/<a class="inventory-vehicle__name" href="(?<url>[^"]+)" title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'make' => '/<a class="inventory-vehicle__name" href="(?<url>[^"]+)" title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'model' => '/<a class="inventory-vehicle__name" href="(?<url>[^"]+)" title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/',
        'price' => '/itemprop="price" content=".*">(?<price>\$[0-9,]+)/',
        'url' => '/<a class="inventory-vehicle__name" href="(?<url>[^"]+)" title="(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+))/'
    ),
    'data_capture_regx_full' => array(
        'stock_number' => '/"subtitle-primary">#(?<stock_number>[^<]+)/',
        'kilometres' => '/Kilometres[^>]+>\s*[^>]+>(?<kilometres>[0-9 ,]+)/',
        'transmission' => '/Transmission[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'body_style' => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'engine' => '/Cylinders[^>]+>\s*[^>]+>(?<engine>[ 0-9 a-z A-Z\.]+)/',
        'exterior_color' => '/Ext. Color[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<img src="\s*(?<img_url>https:\/\/img.sm360.ca\/ir\/(?:w1024h768|w127h80c)\/[^"]+)"(?:\s*\/>|)/',
);
add_filter("filter_macdonaldkiaca_field_images", "filter_macdonaldkiaca_field_images", 10, 2);

function filter_macdonaldkiaca_field_images($im_urls, $car_data) {
    $retval = array();

    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['w127h80c', '\\'], ['w1920h1200', ''], rawurldecode($im_url));
    }

    return $retval;
}
