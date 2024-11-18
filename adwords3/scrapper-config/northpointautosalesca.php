<?php
global $scrapper_configs;
$scrapper_configs["northpointautosalesca"] = array( 
	'entry_points' => array(
        'used' => 'https://www.northpointautosales.ca/used/',
    ),
    'vdp_url_regex' => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
    'refine' => false,
    'srp_page_regex'      => '/ca\/(?:new|used|certified)\//i',
    'picture_selectors' => ['.thumb li'],
    'picture_nexts' => ['.next.stat-arrow-next'],
    'picture_prevs' => ['.prev.stat-arrow-prev'],
    'details_start_tag' => '<div class="instock-inventory-content',
    'details_end_tag'   => '<footer class="opt-3 wp"',
    'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
    'data_capture_regx' => array(

        'url' => '/href="(?<url>[^"]+)"><span/',       
        'year'        => '/itemprop=\'releaseDate\' notranslate>(?<year>[^<]+)/',
        'make'        => '/itemprop=\'manufacturer\' notranslate>(?<make>[^<]+)/',
        'model'       => '/itemprop=\'model\' notranslate>(?<model>[^<]+)/',
        'price'       => '/itemprop="price"[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number' => '/itemprop="sku">(?<stock_number>[^\<]+)/',
        'engine'       => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
        'body_style'   => '/itemprop="bodyType">(?<body_style>[^<]+)/',
        'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Colour:<\/td><td class="[^"]+" itemprop="color" >(?<exterior_color>[^\<]+)/',
        'drivetrain' => '/itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
    	'kilometres'  => '/itemprop="mileageFromOdometer" class="[^"]+">\s*(?<kilometres>[0-9,^<]+)/',
         'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
    ),
    'next_page_regx' => '/class="active"><a\s*href="">[0-9]<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'    => '/img onerror="imgError\(this\);" data-src="(?<img_url>[^"]+)/',
    
);