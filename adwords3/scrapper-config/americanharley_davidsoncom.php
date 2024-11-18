<?php
global $scrapper_configs;
$scrapper_configs["americanharley_davidsoncom"] = array( 
	'entry_points' => array(
		'used' => 'https://americanharley-davidson.com/used-harley-davidson-motorcycles-for-sale-buffalo-ny-xpreownedinventory?page=1',
		'new' => 'https://americanharley-davidson.com/new-harley-davidson-motorcycles-for-sale-buffalo-ny-xnewinventory?page=1',
	),
	'vdp_url_regex' => '/\/inventory\//i',
	'refine' => false,
	'use-proxy' => true,
	'picture_selectors' => ['.imgPreview'],
	'picture_nexts' => ['.r58-slider-arrow-right'],
	'picture_prevs' => ['.r58-slider-arrow-left'],

	'details_start_tag' => '<header id="mainHeader"',
	'details_end_tag' => '<footer class="container-fullWidth">',
	'details_spliter' => '<li class="inventoryList-bike">',

	'data_capture_regx' => array(
		'stock_number' => '/Stock number:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
		'url' => '/class="inventoryList-bike-image">\s*<a\s*href="(?<url>[^"]+)/',
	),
	'data_capture_regx_full' => array(
		'year' => '/year":"(?<year>[^"]+)/',
		'make' => '/make":"(?<make>[^"]+)/',
		'model' => '/model":"(?<model>[^"]+)/',
		'vin' => '/vin":"(?<vin>[^"]+)/',
		'exterior_color' => '/exteriorColor":"(?<exterior_color>[^"]+)/',
		'price' => '/displayedPrice":(?<price>[^}]+)/',
	),
	 'next_query_regx' => '/data-(?<param>page)="(?<value>[0-9]*)"\s*title="Next page">/',
	'images_regx' => '/href="(?<img_url>[^"]+)"\s*data-preview/',
);

