<?php
global $scrapper_configs;
$scrapper_configs["autos4lesscom"] = array( 
	 'entry_points' => array(  
        'used' => 'https://autos4less.com/inventory'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified)-cars\/[0-9]{4}-/i',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.carousel-item img'],
    'picture_nexts' => ['.fi-next'],
    'picture_prevs' => ['.fi-prev'],
    
    'details_start_tag' => '<div id="carList',
    'details_end_tag' => '<footer>',
    'details_spliter' => '<div class="car-container',
    
    'data_capture_regx' => array(
        'url' => '/carlist-item" href="(?<url>[^"]+)/',
        'year' => '/popular-car-title[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)/',
        'make' => '/popular-car-title[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)/',
        'model' => '/popular-car-title[^>]+>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]*)/',
        'stock_number' => '/Stock #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'vin' => '/data-vin-car="(?<vin>[^">]+)/',
        'price' => '/popular-car-price">(?<price>[^<]+)/',
        'interior_color' => '/Interior:<\/span>[^>]+>(?<interior_color>[^<]+)/', 
        'kilometres' => '/Miles:<\/span>[^>]+>(?<kilometres>[^<]+)/'
    ),
    
    'data_capture_regx_full' => array(
        'exterior_color' => '/Exterior color:<\/span>[^>]+>[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'engine' => '/Engine:<\/span>[^>]+>[^>]+>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>[^>]+>[^>]+>[^>]+>(?<transmission>[^<]+)/',

    ),
    'next_page_regx' => '/<a class="next-page" href="(?<next>[^"]+)/',
    'images_regx' => '/data-src="(?<img_url>[^"]+)"[^"]+"[^"]+"\s*alt/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);
