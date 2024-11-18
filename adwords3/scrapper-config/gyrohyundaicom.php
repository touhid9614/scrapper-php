<?php
global $scrapper_configs;
 $scrapper_configs["gyrohyundaicom"] = array( 
	 "entry_points" => array(
		'new' => 'https://www.gyrohyundai.com/new/',
		'used' => 'https://www.gyrohyundai.com/used/'
	),

	    'vdp_url_regex'     => '/\/(?:new|used)\/vehicle\/[0-9]{4}-/i',
        'use-proxy' => true,
        'refine'    => false,
        
        'picture_selectors' => ['.photo-card','.thumb li img'],
        'picture_nexts'     => ['.stat-arrow-next','#viewer-next-button'],
        'picture_prevs'     => ['.left left-small','#viewer-prev-button'],

        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<footer class="footer wp"',
		'details_spliter'   => '<div class="col-xs-12 col-sm-12 col-md-12"',
		
        'data_capture_regx' => array(
            'url'                 => '/href="(?<url>[^"]+)"><span/',
            'year'                => '/itemprop=\'releaseDate\'[^>]+>(?<year>[^\s<]+)/',
            'make'                => '/itemprop=\'manufacturer\'[^>]+>(?<make>[^\s<]+)/',
            'model'               => '/itemprop=\'model\'[^>]+>(?<model>[^\s<]+)/',
            'price'               => '/<span itemprop="price"[^>]+>(?<price>[^\<]+)/',
            'kilometres'          => '/itemprop="mileageFromOdometer"[^>]*>(?<kilometres>[0-9,]+)/',
            'stock_number'        => '/itemprop="sku">(?<stock_number>[^\<]+)/',
            'engine'              => '/itemprop="vehicleEngine">(?<engine>[^\<]+)/',
            'body_style'          => '/itemprop="bodyType">(?<body_style>[^\<]+)/',
            'transmission'        => '/itemprop="vehicleTransmission">(?<transmission>[^\<]+)/',
            'exterior_color'     => '/itemprop="color"\s>(?<exterior_color>[^\<]+)/',
            //'interior_color'      => '/itemprop="vehicleInteriorColor"\s>(?<interior_color>[^\<]+)/'
        ),
        'data_capture_regx_full' => array(        
            'make'                => '/manufacturer:\s*\'(?<make>[^\s<]+)\'/',
        ) ,
        'next_page_regx'    => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
        'images_regx'       => '/imgError\(this\)\;"\s*src="(?<img_url>[^"]+)/'
	);