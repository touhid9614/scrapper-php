<?php

global $scrapper_configs;

$scrapper_configs['korfcontinentalnet'] = array(
    'entry_points' => array(
        'new' => 'https://www.korfcontinental.net/new-inventory/index.htm',
        'used' => 'https://www.korfcontinental.net/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
	'use-proxy' => true,
	
    'picture_selectors' => ['.slider-slide'],
    'picture_nexts' => ['.slider-decorator-0'],
	'picture_prevs' => ['.slider-decorator-1'],
	
    'details_start_tag' => '<div class=" ddc-content inventory-listing-default"',
    'details_end_tag' => '<div  class="ddc-footer">',
    'details_spliter' => '<div class="item-compare">',
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        //'title' => '/class="url"\s*href="(?<url>[^"]+)">\s*(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)[^<]*)/',
        'year' => '/class="url"\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
        'make' => '/class="url"\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
        'model' => '/class="url"\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url' => '/class="url"\s*href="(?<url>[^"]+)">\s*(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+)/'
    ),

    'data_capture_regx_full' => array(
        
        'stock_number' => '/Stock:\s*[^>]+>(?<stock_number>[^<]+)/',
    ),

    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);