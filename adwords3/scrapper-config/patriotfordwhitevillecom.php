<?php
global $scrapper_configs;
$scrapper_configs["patriotfordwhitevillecom"] = array( 
	'entry_points' => array(
		'used' => 'https://www.patriotfordwhiteville.com/searchused.aspx',
        'new' => 'https://www.patriotfordwhiteville.com/searchnew.aspx',
        
    ),
    'vdp_url_regex' => '/\/(?:new|used)-[^-]*-[0-9]{4}-/i',
     'refine' => false,
    'picture_selectors' => ['.img-responsive'],
    'picture_nexts' => ['.mfp-arrow-right.mfp-prevent-close'],
    'picture_prevs' => ['.mfp-arrow-left.mfp-prevent-close'],
    'details_start_tag' => '<div id="srp-inventory"',
    'details_end_tag' => '<footer class="full',
    'details_spliter' => 'class="vehicle-card vehicle-card--mod vehicle-card-- vehicle',
    'data_capture_regx' => array(
        'url'   => '/<a class="vehicle-title"\s*[^"]+"[^"]+"\s*href="(?<url>[^"]+)"/',
        'title' => '/title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))">\s*<h3 class="vehicle-title__text h2">/',
        'year'  => '/title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))">\s*<h3 class="vehicle-title__text h2">/',
        'make'  => '/title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))">\s*<h3 class="vehicle-title__text h2">/',
        'model' => '/title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^"]+))">\s*<h3 class="vehicle-title__text h2">/',
        'price' => '/<span class="vehiclePricingHighlightAmount\s*">(?<price>[^<]+)<\/span>\s*<[^>]+>BEST PRICE/',
        'vin'   => '/VIN:\s*[^>]+>\s*<span class="vehicle-identifiers__value">(?<vin>[^<]+)/',
        'stock_number'   => '/Stock:\s*[^>]+>\s*<span class="vehicle-identifiers__value">(?<stock_number>[^<\/]+)/',
    ),
    'data_capture_regx_full' => array(
    	'body_style'     => '/Body Style[^>]+>\s*[^>]+>(?<body_style>[^<\/]+)/',
    	//'transmission'   => '/<strong>Transmission:\s*[^>]+>(?<transmission>[^<\/]+)<\/li>\s*<li class="ext/',
        'engine'         => '/Engine[^>]+>\s*[^>]+>(?<engine>[^<\/]+)/',
        'exterior_color' => '/Exterior Color[^>]+>\s*[^>]+>\s*(?<exterior_color>[^<\/]+)/',
       // 'interior_color' => '/class="intColor"><strong>Int. Color: <\/strong>(?<interior_color>[^<\/]+)/',  
        'kilometres'     => '/Mileage[^>]+>\s*[^>]+>\s*(?<kilometres>[^<\/]+)/',

    ),
    'next_page_regx' => '/<a href=\'(?<next>[^\']+)\'\s*class="stat-arrow-next"[^>]+>\s*Next/',
    'images_regx' => '/<picture>\s*<source media="[^"]+"\s*(?:data-srcset|srcset)="(?<img_url>[^?]+)/',
  
);
