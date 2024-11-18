<?php
global $scrapper_configs;
$scrapper_configs["grindstaffkia"] = array(
	"entry_points" => array(
		'new' => 'https://www.grindstaffkia.com/inventory?type=new',
		'used' => 'https://www.grindstaffkia.com/inventory?type=used',

	),
	'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
	//'ty_url_regex' => '/\/form\/confirm.htm/i',
	'use-proxy' => true,
	// 'proxy-area'        => 'FL',
	'picture_selectors' => ['.MagicZoom'],
	'picture_nexts' => ['.slick-next'],
	'picture_prevs' => ['.slick-prev'],

	'details_start_tag' => '<div class="large-9 columns srp-results">',
	'details_end_tag' => '<div class="small-12 columns">',
	'details_spliter' => '<div class="srp-bottom-bar-item saveDiv">',

	'data_capture_regx' => array(
		'url' => '/srp-vehicle-title"[^\/]*(?<url>[^"]+)">[^>]*>(?<title>[^<]+)/',
		'title' => '/srp-vehicle-title"[^\/]*(?<url>[^"]+)">[^>]*>(?<title>[^<]+)/',
		'year' => "/releaseDate'[^']*'(?<year>[^']+)/",
		'make' => "/manufacturer'[^']*'(?<make>[^']+)/",
		'model' => "/model'[^']*'(?<model>[^']+)/",
		//'trim' => '/data-trim="(?<trim>[^"]+)/',
		'price' => '/Final Price:[^\$]+\$<span itemprop="price" content="(?<price>[0-9,]+)/',
		'kilometres' => "/Mileage:<\/span>(?<kilometres>[^<]+)/",
		'stock_number' => "/sku'[^']*'(?<stock_number>[^']+)/",
		'transmission'      => "/Transmission:<\/span>(?<transmission>[^<]+)/",
		'engine' => "/Engine:<\/span>(?<engine>[^<]+)/",
		//'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
		'exterior_color' => "/color'[^']*'(?<exterior_color>[^']+)/",
		'interior_color' => '/Int. Color:<\/span>(?<interior_color>[^<]+)/',
	),
	'data_capture_regx_full' => array(
	 //'make' => '@make\: \'(?<make>[^\']+)\'@',
	 //'model' => '@model\: \'(?<model>[^\']+)\'@',
	 'body_style' => '/Body Style:<\/span>(?<body_style>[^<]+)/',
	 //'trim' => '@"trim": "(?<trim>[^"]+)@',
	 //'price' => '/class="h1 price" >(?<price>\$[0-9,]+)<\/strong>\s*<span class="[^>]+>Now Only/',
	),
	'next_page_regx' => "/class='arrow'[^\/]*(?<next>[^']+)'>&raquo;/",
	'images_regx' => '/data-zoom-id="vehicleGallery"[^"]*"(?<img_url>[^"]+)/',
	'images_fallback_regx' => '/meta itemprop="image"[^"]*"(?<img_url>[^"]+)/'
);