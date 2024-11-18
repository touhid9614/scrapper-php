<?php
global $scrapper_configs;
$scrapper_configs["lakingtoyotacom"] = array( 

	"entry_points" => array(
         'used' => 'https://www.lakingtoyota.com/en/used-inventory?limit=200',
         'new' => 'https://www.lakingtoyota.com/en/new-inventory?limit=200',
       
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used|certified)-inventory\//i',
    'ty_url_regex' => '/\/en\/thank-you/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.gallery-delta__thumbnails-item span.overlay img'],
    'picture_nexts' => ['div.gallery-delta-slider__controls a:nth-of-type(2)'],
    'picture_prevs' => ['div.gallery-delta-slider__controls a:nth-of-type(1)'],
    'details_start_tag' => '<section class="inventory-listing-charlie__content',
    'details_end_tag' => '<footer',
    'details_spliter' => '<article class="inventory-tile inventory-listing-charlie__vehicles-item',
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-tile-section-vehicle-link"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
       
        'stock_number' => '/stock.*<\/span>\s*<span itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
        'vin' => '/data-vin="(?<vin>[^"]+)/',
        'year' => '/<a class="inventory-tile-section-vehicle-link"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'make' => '/<a class="inventory-tile-section-vehicle-link"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'model' => '/<a class="inventory-tile-section-vehicle-link"\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
        'price' => '/<span itemprop="price"\s*.*\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage:<\/div>\s*[^>]+>(?<kilometres>[^<]+)/',
        'body_style' => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'transmission' => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
         'description' => '/<meta name="description" content="(?<description>[^"]+)/',

        'drivetrain' => '/Drivetrain:<\/div>\s*[^>]+>(?<drivetrain>[^<]+)/',
        'fuel_type'      => '/Fuel:<\/div>\s*[^>]+>(?<fuel_type>[^<]+)/',
    ),
  //  'next_page_regx' => '/<a class="pagination__page-arrows-text\s"\shref="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
    'images_regx' => '/<span class="overlay">\s*<img src="(?<img_url>[^"]+)"\s*alt="/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);