<?php

global $scrapper_configs;

$scrapper_configs['audikirkwoodcom'] = array(
    'entry_points' => array(
        'new' => 'https://www.audikirkwood.com/new-inventory/index.htm',
        'used' => 'https://www.audikirkwood.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-/i',
	'use-proxy' => true,
	
    'picture_selectors' => ['.slider-slide'],
    'picture_nexts' => ['.slider-decorator-0'],
	'picture_prevs' => ['.slider-decorator-1'],
	
    'details_start_tag' => '<div class="page-bd" data-page-body>',
    'details_end_tag' => '<div  class="ddc-footer">',
	'details_spliter' => '<li class="item notshared',
	
    'data_capture_regx' => array(
        'stock_number' => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title' => '/class="url" *href="(?<url>[^"]+)">\s*(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)[^<]*)/',
        'year' => '/class="url" *href="(?<url>[^"]+)">\s*(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)[^<]*)/',
        'make' => '/class="url" *href="(?<url>[^"]+)">\s*(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)[^<]*)/',
        'model' => '/class="url" *href="(?<url>[^"]+)">\s*(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)[^<]*)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^<]+)/',
        'exterior_color' => '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres' => '/<dt>Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
		'url' => '/class="url" *href="(?<url>[^"]+)">\s*(?<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)[^<]*)/',
		'vin' => '/VIN:\s*<\/dt>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
		'vin' => '/VIN:\s*<[^>]+>(?<vin>[^<]+)/',
    ),
    'next_page_regx' => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/"id":[^"]+"src":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);