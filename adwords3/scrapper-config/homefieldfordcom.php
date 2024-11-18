<?php
global $scrapper_configs;
$scrapper_configs["homefieldfordcom"] = array( 
	"entry_points" => array(
	    'new' => array(
			'https://www.homefieldford.com/inventory.html?filterid=a1b3d19q0-10x0-0-0+W3sidHNlYXJjaCI6W3sibiI6ImZpZWxkc2VhcmNoIiwidiI6IjIzMDUxLW5ldyIsInMiOjF9XX1d',
			'https://www.homefieldford.com/new/inventory/search.html',
		),
		
        'used' => 'https://www.homefieldford.com/used/inventory/search.html',
    ),     
    // 'vdp_url_regex' 	=> '/\/(?:new|used|demos)\/inventory\/[0-9]{4}/i',
    // 'srp_page_regex'    => '/\/(?:new|used|demos)\/inventory/i',

	'vdp_url_regex'     => '/\/(?:new|used)\/(?:inventory|[0-9]{4})(?:\/|\-)[A-z0-9]+\-/i',
    'srp_page_regex'    => '/\/(?:new|used)\/(?:search|inventory)(?:\/|\.)(?:html|search)/',
	
    'refine' => false,
	'use-proxy' => false,
	'details_start_tag' => 'header.mobile-header',
	'details_end_tag' => 'class="conditionsFooter -w50p">',
	'details_spliter' => 'class="carBoxWrapper"',
	'data_capture_regx' => array(
		'url' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
		'year' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
		'make' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*/',
		'model' => '/<a\s*href="(?<url>[^"]+)"\s*title="(?<year>[^\s*]+)\s*(?<make>[^\s*]+)\s*(?<model>[^\s*]+)/',
		'price' => '/carPrice elIsLoadable[^>]+>[^>]+>(?<price>[^<]+)/',
	),
	'data_capture_regx_full' => array(
		'model' => '/Model:(?<model>[^<]+)/',
		'price' => '/name="vehiclePrice"\s*value="(?<price>[^"]+)/',
		'stock_number' => '/expressstocknumber\' value=\'(?<stock_number>[^\']+)/',
		'kilometres' => '/data-km="(?<kilometres>[^"]+)/',
		'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
		'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
		'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
		'body_style' => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
		'vin'           => '/data-vin="(?<vin>[^"]+)/',
	),
   
    'images_regx' => '/rel="slider-lightbox[^"]+" href="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/og:image"\s*content="(?<img_url>[^"]+)/'
);

