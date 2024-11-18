<?php
global $scrapper_configs;
$scrapper_configs["adventurervctrcom"] = array( 
	'entry_points' => array(
            'used'  => 'https://inventory.adventurervctr.com/used/?perPage=50',
            'new'   => 'https://inventory.adventurervctr.com/new/?perPage=50',
            
        ),
        'vdp_url_regex'     => '/\/(?:new|used)\/[A-Za-z0-9-]+\/[0-9]{4}-/i',
        'use-proxy' => true,
        
        'details_start_tag' => '<!-- RV Repeater -->',
        'details_end_tag'   => '<!-- End Listings Row -->',
        'details_spliter'   => '<div class="rv-repeater-item">',
    
        'data_capture_regx' => array(
        'url'                 => '/<a href="(?<url>[^"]+)" title="View Details">/',
        'year'                => '/<div class="col-xs-12">\s*<h3>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'make'                => '/<div class="col-xs-12">\s*<h3>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'model'               => '/<div class="col-xs-12">\s*<h3>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^<]+)/',
        'price'               => '/Our Price<\/span>[^>]+>(?<price>\$[0-9,]+)/',
        'stock_number'        => '/Stock \#<\/td>\s*<td>(?<stock_number>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    	
//        'kilometres'         => '/itemprop="mileageFromOdometer"[^>]+>\s*(?<kilometres>[^<]+)/',
//        'engine'             => '/itemprop="vehicleEngine">\s*(?<engine>[^\<]+)/',
//        'body_style'         => '/itemprop="bodyType">\s*(?<body_style>[^\<]+)/',
//        'transmission'       => '/itemprop="vehicleTransmission">\s*(?<transmission>[^\<]+)/',
//        'exterior_color'     => '/itemprop="color"\s>\s*(?<exterior_color>[^\<]+)/',
//        'interior_color'     => '/itemprop="vehicleInteriorColor"\s*>\s*(?<interior_color>[^\<]+)/',
//        'vin'                => '/vin:\s*\'(?<vin>[^\']+)/',
    ),
    //'next_page_regx' => '/class="active"><a\s*href="">[0-9]*<\/a><\/li>\s*<li><a\s*href="(?<next>[^"]+)/',
    'images_regx'              => '/class="thumbs">[^"]+"[^"]+" data-lazy="(?<img_url>[^"]+)" alt="/'
);
