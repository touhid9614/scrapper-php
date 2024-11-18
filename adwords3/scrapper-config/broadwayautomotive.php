<?php
global $scrapper_configs;
 $scrapper_configs["broadwayautomotive"] = array( 
	 "entry_points" => array(
		'new'  => 'https://www.broadwayautomotive.com/new-cars-green-bay-wi',
		'used' => 'https://www.broadwayautomotive.com/used-cars-green-bay-wi'
	 ),
	 'vdp_url_regex'     => '/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
		'use-proxy' => true,
		
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.prev'],
        
		'details_start_tag' => '<div class="inventory-listing-wrapper"',
        'details_end_tag'   => '<div class="col-xs-12 col-md-3 col-filter',
		'details_spliter'   => '<div class="inventory-listing-item" itemprop="offers"',
		
        'data_capture_regx' => array(
            'url'           => '/itemprop="url" content="(?<url>[^"]+)/',
            'title'         => '/itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/releaseDate" content="(?<year>[^"]+)/',
            'make'          => '/brand" content="(?<make>[^"]+)/',
            'model'         => '/model" content="(?<model>[^"]+)/',
            //'trim'          => '/data-trim="(?<trim>[^"]+)/',
            'price'         => '/price-value text-bold sale-font[^$]*(?<price>[^<]+)/',
            'kilometres'    => '/inventory-listing-item_info_miles">\s*(?<kilometres>[^Mil]+)/',
            'stock_number'  => '/sku" content="(?<stock_number>[^"]+)/',
            //'engine'        => '/Engine:<\/dt> <dd>(?<engine>[^<]+)/',
            //'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            // 'transmission'  => '/sku" content="(?<transmission>[^"]+)/',
            'exterior_color'=> '/itemprop="color" content="(?<exterior_color>[^"]+)/',
            //'interior_color'=> '/Interior Color:<\/dt> <dd>(?<interior_color>[^<]+)/'
		),
		'data_capture_regx_full' => array(
			'trim'          => '/class="vehicle-trim">(?<trim>[^<]+)/',
			'kilometres'    => '/icon-mileage" \/>\s*<\/svg>\s*<span>\s*(?<kilometres>[^<]+)/',
			'stock_number'  => '/icon-stock-number" \/>\s*<\/svg>\s*<span>\s*(?<stock_number>[^<]+)/',
           	'engine'        => '/icon-engine" \/>\s*<\/svg>\s*<span>\s*(?<engine>[^<]+)/',
        	//'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'transmission'  => '/icon-transmission" \/>\s*<\/svg>\s*<span>\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/icon-exterior-color" \/>\s*<\/svg>\s*<span>\s*(?<exterior_color>[^<]+)/',
            'interior_color'=> '/icon-interior-color" \/>\s*<\/svg>\s*<span>\s*(?<interior_color>[^<]+)/'
           
        ),
		
        'next_page_regx'    => '/pagination_btn next[^=]*="(?<next>[^"]+)/',
        'images_regx'       => '/media-element"[^"]*"(?<img_url>[^"]+)/'
	);