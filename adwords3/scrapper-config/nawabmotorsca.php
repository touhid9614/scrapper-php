<?php
global $scrapper_configs;
$scrapper_configs["nawabmotorsca"] = array( 
	'entry_points' => array(
        'used' => 'https://www.nawabmotors.ca/used-cars/'
    ),
     
     'use-proxy' => true,
     'refine'=>false,
    'vdp_url_regex' => '/\/(?:new|used)\/[0-9]{4}-/i',
    'picture_selectors' => ['.slides li img'],
    'picture_nexts' => ['.flex-next'],
    'picture_prevs' => ['.flex-prev'],
    'details_start_tag' => '<div class="main-content-inner',
    'details_end_tag' => '<div id="footer-area">',
    'details_spliter' => '<div class="vehicle search-result-item vehicleList">',
    'data_capture_regx' => array(
        'url' => '/class="col-md-12">\s*<a href="(?<url>[^"]+)/', 
        'engine' => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',  
        'year' => '/class="vehicleName"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)[^<]*)/',
        'make' => '/class="vehicleName"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)[^<]*)/',
        'model' => '/class="vehicleName"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s*<]+)[^<]*)/',
        'stock_number' => '/Stock #:<\/span><span >(?<stock_number>[^<]+)/',
        'price' => '/<div class="priceVal">(?<price>[^<]+)/',
        'transmission' => '/>Transmission[^>]+>[^>]+>(?<transmission>[^<]+)/',
        'exterior_color' => '/>Exterior:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'body_style' => '/>Body Style:[^>]+>[^>]+>(?<body_style>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
       'kilometres'    => '/>Odometer:[^>]+>[^>]+>(?<kilometres>[^\s]+)/',
    ),
    'next_page_regx' => '/<a class="next page-numbers" href="(?<next>[^"]+)"/',
    'images_regx' => '/<img\s*alt=".*"\s*src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
