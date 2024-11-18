<?php

global $scrapper_configs;
$scrapper_configs["carlylegm"] = array(
    'entry_points' => array(
        'new'  => 'https://www.carlylegm.ca/inventory/new/',
        'used' => 'https://www.carlylegm.ca/inventory/used/',
    ),
    'use-proxy' => true,
    'refine'    => false,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)/i',
    'ty_url_regex' => '/\/inventory\/thank_you/i',
    'picture_selectors' => ['.slick-slide',],
    'picture_nexts' => ['button.slick-next'],
    'picture_prevs' => ['button.slick-prev'],
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        'year' => '/class="vehicle-title--year">\s*(?<year>[0-9]{4})/',
        'make' => '/class="notranslate vehicle-title--make ">\s*(?<make>[^<]+)/',
        'model' => '/class="notranslate vehicle-title--model ">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>\s*(?<stock_number>[^<]+)/',
        'price' => '/class="currency">\$[^>]+>[^>]+>(?<price>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine' => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'drivetrain' => '/Drivetrain:<\/span>[^>]+>(?<drivetrain>[^<]+)/',
        'exterior_color' => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/',
        'vin' => '/VIN#:<\/span>[^"]+"[^"]+">(?<vin>[^<]+)/',
        'description' => '/vehicle-descriptions__value ">(?<description>[^<]+)/',
        'body_style' => '/data-vehicle="standardbody" >(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/stat-image-link" alt="[^"]+"\s*src="[^"]++" data-src="(?<img_url>[^"]+)"/',
);
