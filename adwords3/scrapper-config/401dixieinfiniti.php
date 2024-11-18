<?php

global $scrapper_configs;
$scrapper_configs["401dixieinfiniti"] = array(
    'entry_points' => array(
        'new' => 'https://www.401dixieinfiniti.ca/en/new-inventory',
        'used' => 'https://www.401dixieinfiniti.ca/en/used-inventory',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used|certified)-inventory\//i',
    //'ty_url_regex' => '/\/en\/thank-you/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.gallery-delta__thumbnails-item span.overlay img'],
    'picture_nexts' => ['div.gallery-delta-slider__controls a:nth-of-type(2)'],
    'picture_prevs' => ['div.gallery-delta-slider__controls a:nth-of-type(1)'],
    
    'details_start_tag' => '<div class="inventory-listing-charlie__vehicles">',
    'details_end_tag' => '<div class="page-wrapper footer-bottom__wrapper">',
    'details_spliter' => '<article class="inventory-tile inventory-listing-charlie__vehicles-item"',
    'data_capture_regx' => array(
        'url' => '/<a class="" href="(?<url>[^"]+)"\s*title="(?<title>[^"]+)/',
        'title' => '/<a class="" href="(?<url>[^"]+)"\s*title="(?<title>[^"]+)/',
        'stock_number' => '/stock.*<\/span>\s*<span itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'year' => '/class="inventory-tile-section-vehicle-name--year-make">(?<year>[0-9]{4})\s*(?<make>[^<]+)/',
        'make' => '/class="inventory-tile-section-vehicle-name--year-make">(?<year>[0-9]{4})\s*(?<make>[^<]+)/',
        'model' => '/class="inventory-tile-section-vehicle-name--model-name">(?<model>[^<]+)/',
        'price' => '/<span itemprop="price"\s*.*\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage:<\/div>\s*[^>]+>(?<kilometres>[^<]+)/',
        'body_style' => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/<a class="pagination__page-arrows-text\s"\shref="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
    'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
