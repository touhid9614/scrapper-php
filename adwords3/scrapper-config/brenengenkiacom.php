<?php
global $scrapper_configs;
$scrapper_configs["brenengenkiacom"] = array(
    'entry_points'           => array(
        'used' => 'https://www.brenengenkia.com/used-vehicles-west-salem-wi?limit=100',
        'new'  => 'https://www.brenengenkia.com/new-vehicles-west-salem-wi?limit=100',
    ),

    'vdp_url_regex'          => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    // 'ty_url_regex'          => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    'srp_page_regex'         => '/\/(?:new|used)-/i',

    'use-proxy'              => true,
    'refine'                 => false,

    'picture_selectors'      => ['.zoom-thumbnails__thumbnail'],
    'picture_nexts'          => ['.df-icon-chevron-right'],
    'picture_prevs'          => ['.df-icon-chevron-left'],

    'details_start_tag'      => '<div class="inventory-listing vehicle-items',
    'details_end_tag'        => '<footer',
    'details_spliter'        => '<div class="vehicle-item inventory-listing__item',

    'data_capture_regx'      => array(
        'stock_number' => '/"Stock">[^>]+>\s*[^\s]+\s(?<stock_number>[^<]+)/',
        'url'          => '/vehicle-item-descr">\s*<a href="(?<url>[^"]+)/',
        'year'         => '/vehicle-item-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make'         => '/vehicle-item-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model'        => '/vehicle-item-title">\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'price'        => '/TRU DISCOUNT PRICE\s*[^>]+>[^>]+>\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'exterior_color' => '/Exterior Color<\/div>[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color<\/div>[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'engine'         => '/Engine:\s*(?<engine>[^<]+)/',
        'transmission'   => '/Transmission<\/div>[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'stock_number'   => '/vehicle-highlights__subtitle-value">\s*#\s*(?<stock_number>[^<]+)/',
        'kilometres'     => '/Mileage:\s*(?<kilometres>[^<]+)/',
        'vin'            => '/VIN<\/span>[^>]+>(?<vin>[^<]+)/',
        'body_style'     => '/Body Style<\/div>[^>]+>[^>]+>(?<body_style>[^<]+)/',

        'description'    => '/<h4 class="js-module-heading">\s*ABOUT THIS VEHICLE\s*[^>]+>\s*[^>]+>\s*(?<description>[^<]+)/',
    ),
    'images_regx'            => '/class="main-slider__inner-img" src="(?<img_url>[^"]+)"/',
    'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);
